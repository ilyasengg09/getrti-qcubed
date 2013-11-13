<?php

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

	public $lblMsg;


	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$userMan = new UserManagement();
		if($userMan->getUser()!=null){
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
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
		$this->btnLogin->Text = "Log In";
		$this->btnLogin->ButtonMode = QButtonMode::Success;
		$this->btnLogin->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnLogin_Click'));

		// register form
		$this->txtRegName = new QTextBox($this);
		$this->txtRegName->Placeholder = "Your Name";
		$this->txtRegName->Name = "Name";

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
		$this->btnRegister->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnRegister_Click'));


		$this->lblMsg = new IAlertLabel($this);
		$this->lblMsg->Visible = false;

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
		$t_hasher = new PasswordHash(8, false);
		// checking all fields are filled
		if($this->txtLogUsername->Text == "" || $this->txtLogPassword == ""){
			$this->lblMsg->Text = "You must fill both the username and password fields.";
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Warning;
			$this->lblMsg->Visible = true;
			return false;
		}
		if(filter_var($this->txtLogUsername->Text, FILTER_VALIDATE_EMAIL)){
			$user = Users::LoadByEmail($this->txtLogUsername->Text);
			if($user == null){
				$this->lblMsg->Text = "That didn't work. Please try again.";
				$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
				$this->lblMsg->Visible = true;
				return false;
			}
			elseif($t_hasher->CheckPassword($this->txtLogPassword->Text, $user->Password)){
				return $user;
			}
			else{
				return false;
			}
		}
		else{
			$user = Users::LoadByUsername($this->txtLogUsername->Text);
			if($user == null){
				$this->lblMsg->Text = "That didn't work. Please try again.";
				$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
				$this->lblMsg->Visible = true;
				return false;
			}
			elseif($t_hasher->CheckPassword($this->txtLogPassword->Text, $user->Password)){
				return $user;
			}
			else{
				return false;
			}
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
			$this->lblMsg->Visible = true;
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Success;
			$this->txtRegName->Text = "";
			$this->txtRegUsername->Text = "";
			$this->txtRegEmail->Text = "";
			$this->txtRegPassword->Text = "";
			$this->txtRegPasswordRepeat->Text = "";
		}
	}

	public function btnLogin_Click($strFormId, $strControlId, $strParameter){
		if($this->Form_Validate_Login()){
			$user = $this->Form_Validate_Login();
			$userMan = new UserManagement();
			$userMan->addSession($user->Email);
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__);
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}