<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  * Login Page
  */


require_once __EXTERNAL_LIBRARIES__ . '/phpass/PasswordHash.php';

class LoginController extends QPanel{

	public $strPageTitle;

	public $txtLogUsername;
	public $txtLogPassword;
	public $btnLogin;

	public $txtRegName;
	public $txtRegEmail;
	public $txtRegUsername;
	public $txtRegPassword;
	public $txtRegPasswordRepeat;
	public $btnRegister;

	public $strFbLogin;

	public $lblMsg;
	public $lblLoginMsg;


	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}
		$utils = new Utils();

		$userMan = new UserManagement();
		if($userMan->getUser()!=null){
			if(isset($_GET['next'])){
				QApplication::Redirect($_GET['next']);
			}
			else{
				QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
			}
		}

		// test if logged in via facebook
		$fbUser = $this->facebook->getUser();
		if($fbUser){
			// if logged in via facebook
			// check if this account exists
			$user_profile = $this->facebook->api('/me','GET');
			if($userMan->isRegistered($user_profile['email'])){
				$userMan->addSession($user_profile['email']);
				if(isset($_GET['next'])){
					QApplication::Redirect($_GET['next']);
				}
				else{
					QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
				}
			}
			// if account doesnt exist
			else{
				$user = new Users();
				$user->Name = $user_profile['name'];
				$user->Username = $user_profile['username'];
				$user->Email = $user_profile['email'];
				$t_hasher = new PasswordHash(8, false);
				$hashedPassword = $t_hasher->HashPassword($utils->get_random_string(10));
				$user->Password = $hashedPassword;
				$user->Save();
				$userMan->addSession($user_profile['email']);
				if(isset($_GET['next'])){
					QApplication::Redirect($_GET['next']);
				}
				else{
					QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
				}
			}
		}


		// login form
		$this->txtLogUsername = new QTextBox($this);
		$this->txtLogUsername->Placeholder = "Your username or E-mail?";
		$this->txtLogUsername->Name = "Username";

		$this->txtLogPassword = new QTextBox($this);
		$this->txtLogPassword->Placeholder = "And your password please";
		$this->txtLogPassword->TextMode = QTextMode::Password;
		$this->txtLogPassword->Name = "Password";

		$this->btnLogin = new QButton($this);
		$this->btnLogin->Text = "Log In With Email";
		$this->btnLogin->ButtonMode = QButtonMode::Success;
		$this->btnLogin->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnLogin_Click'));

		// facebook login
		if(isset($_GET['next'])){
			$redirUrl =	__SM_SITE_ADDRESS__.__SM_URL_REWRITE__.'/login?next='.$_GET['next'];
		}
		else{
			$redirUrl =	__SM_SITE_ADDRESS__.__SM_URL_REWRITE__.'/login';
		}

		$strLoginLink = $this->facebook->getLoginUrl(
			array(
				'redirect_uri' => $redirUrl,
				'scope' => 'email',
			)
		);
		$this->strFbLogin = "<a href='".$strLoginLink."'><img src='".__SM_SITE_ABSOLUTE__ADDRESS__.__APP_IMAGE_ASSETS__."/fb_login.png' /></a>";

		// register form
		$this->txtRegName = new QTextBox($this);
		$this->txtRegName->Placeholder = "Your Name";
		$this->txtRegName->Name = "Full Name";

		$this->txtRegEmail = new QTextBox($this);
		$this->txtRegEmail->Placeholder = "An e-mail where we can contact you";
		$this->txtRegEmail->Name = "E-mail";

		$this->txtRegUsername = new QTextBox($this);
		$this->txtRegUsername->Placeholder = "Choose a username";
		$this->txtRegUsername->Name = "Username";

		$this->txtRegPassword = new QTextBox($this);
		$this->txtRegPassword->Placeholder = "Type a password";
		$this->txtRegPassword->TextMode = QTextMode::Password;
		$this->txtRegPassword->Name = "Password";

		$this->txtRegPasswordRepeat = new QTextBox($this);
		$this->txtRegPasswordRepeat->Placeholder = "The above password again, please";
		$this->txtRegPasswordRepeat->TextMode = QTextMode::Password;
		$this->txtRegPasswordRepeat->Name = "Repeat Password";

		$this->btnRegister = new QButton($this);
		$this->btnRegister->Text = "Register";
		$this->btnRegister->ButtonMode = QButtonMode::Info;
		$this->btnRegister->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnRegister_Click'));


		$this->lblMsg = new IAlertLabel($this);
		$this->lblMsg->Visible = false;

		$this->lblLoginMsg = new IAlertLabel($this);
		$this->lblLoginMsg->Visible = false;

		if(isset($_GET['next'])){
			$this->lblLoginMsg->Text = "You need to login to complete that action";
			$this->lblLoginMsg->AlertLabelMode = IAlertLabelMode::Info;
			$this->lblLoginMsg->Visible = true;
		}

		$this->strTemplate = __VIEWS_PATH__ . '/LoginView.tpl.php';

		$this->strPageTitle = __SM_APP_NAME__." - Log In";
	}

	public function Form_Validate_Register(){
		$this->lblMsg->Text = "<ul>";
		$error = 0;
		// check all fields are filled
		if($this->txtRegName->Text == "" || $this->txtRegUsername->Text == "" || $this->txtRegPassword->Text == "" || $this->txtRegEmail->Text == ""){
			$this->lblMsg->Text .= "<li>All fields are required. </li>";
			$error = 1;
		}
		// checking name contains letters and spaces
		if (preg_match('/[^a-z\s]/i', $this->txtRegName->Text)) {
			$this->lblMsg->Text .= "<li>Name can consist of letter and spaces only.</li>";
			$error = 1;
		}
		//check username
		if(preg_match('/[^A-Za-z0-9]/', $this->txtRegUsername->Text)){
			$this->lblMsg->Text .= "<li>Username can consist of only letters and digits.</li>";
			$error = 1;
		}
		// checking if user exists
		if(Users::LoadByUsername($this->txtRegUsername->Text)!= null){
			$this->lblMsg->Text .= "<li>Sorry, that username seems to be already taken.</li>";
			$error = 1;
		}
		// checking email
		if(filter_var($this->txtRegEmail->Text, FILTER_VALIDATE_EMAIL)==false){
			$this->lblMsg->Text .= "<li>Your e-mail seems not to be a valid one.</li>";
			$error = 1;
		}
		// checking if email exists
		if(Users::LoadByEmail($this->txtRegEmail->Text)!= null){
			$this->lblMsg->Text .= "<li>That E-mail has already registered here.</li>";
			$error = 1;
		}
		// checking password
		if($this->txtRegPassword->Text != $this->txtRegPasswordRepeat->Text){
			$this->lblMsg->Text .= "<li>Your passwords do not match.</li>";
			$this->txtRegPassword->Text = "";
			$this->txtRegPasswordRepeat->Text = "";
			$error = 1;
		}
		if(strlen($this->txtRegPassword->Text)<8){
			$this->lblMsg->Text .= "<li>To prevent crackers, please supply a password of atleast 8 digits.</li>";
			$error = 1;
		}
		if(strlen($this->txtRegPassword->Text)>32){
			$this->lblMsg->Text .= "<li>Passwords cannot be more than 32 characters long.</li>";
			$error = 1;
		}
		if($error==1){
			$this->lblMsg->Visible = true;
			$this->lblMsg->Text .= "</ul>";
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
			return false;
		}
		else{
			return true;
		}
	}

	public function Form_Validate_Login(){
		$this->lblMsg->Text = "<ul>";
		$error = 0;
		$t_hasher = new PasswordHash(8, false);
		// checking all fields are filled
		if($this->txtLogUsername->Text == "" || $this->txtLogPassword == ""){
			$this->lblMsg->Text.= "<li>You must fill both the username and password fields.</li>";
			$error = 1;
		}
		if(filter_var($this->txtLogUsername->Text, FILTER_VALIDATE_EMAIL)){
			$user = Users::LoadByEmail($this->txtLogUsername->Text);
			if($user == null){
				$this->lblMsg->Text.= "<li>That didn't work. Please try again.</li>";
				$error = 1;
			}
			elseif($t_hasher->CheckPassword($this->txtLogPassword->Text, $user->Password)){
				return $user;
			}
			else{
				$this->lblMsg->Text.= "<li>That didn't work. Please try again.</li>";
				$error = 1;
			}
		}
		else{
			$user = Users::LoadByUsername($this->txtLogUsername->Text);
			if($user == null){
				$this->lblMsg->Text.= "<li>That didn't work. Please try again.</li>";
				$error = 1;

			}
			elseif($t_hasher->CheckPassword($this->txtLogPassword->Text, $user->Password)){
				return $user;
			}
			else{
				$this->lblMsg->Text.= "<li>That didn't work. Please try again.</li>";
				$error = 1;
			}
		}
		if($error==1){
			$this->lblMsg->Text.= "</ul>";
			$this->lblMsg->Visible = true;
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
		}
	}

	public function btnRegister_Click($strFormId, $strControlId, $strParameter){
		if($this->Form_Validate_Register()){
			$user = new Users();
			$user->Name = $this->txtRegName->Text;
			$user->Username = $this->txtRegUsername->Text;
			$user->Email = $this->txtRegEmail->Text;
			$t_hasher = new PasswordHash(8, false);
			$hashedPassword = $t_hasher->HashPassword($this->txtRegPassword->Text);
			$user->Password = $hashedPassword;
			$user->Save();
			$this->lblMsg->Text = "Your account has been registered. Please log in.";
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Success;
			$this->lblMsg->Visible = true;
			$this->txtRegName->Text = "";
			$this->txtRegUsername->Text = "";
			$this->txtRegEmail->Text = "";
			$this->txtRegPassword->Text = "";
			$this->txtRegPasswordRepeat->Text = "";
		}
	}

	public function btnLogin_Click($strFormId, $strControlId, $strParameter){
		$utils = new Utils();
		if($this->Form_Validate_Login()){
			$user = $this->Form_Validate_Login();
			$userMan = new UserManagement();
			$userMan->addSession($user->Email);
			if(isset($_GET['next'])){
				QApplication::Redirect($_GET['next']);
			}
			else{
				QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
			}
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}