<?php require_once 'qcubed.inc.php';

class Index extends QForm{

	/** @var string Title of the page */
	protected $strTitle = "QCubed Improved";
	/** @var string The string to hold the PathInfo */
	protected $strPathInfo = '';
	/** @var QPanel The middle body Panel of the page */
	protected $pnlPageMainBody;
	/** @var QPanel The page header and footer panels for the page. */
	protected $pnlPageHeader, $pnlPageFooter;

	protected $strUserMsg;

	public function Form_Create() {
		// Get the Top Panel
		$this->pnlPageHeader = new HeaderPanel($this, null);
		// and the bottom one
		$this->pnlPageFooter = new FooterPanel($this, null);
		// and get the main page
		$this->pnlPageMainBody = $this->SetController();
		$userMan = new UserManagement();
		if($userMan->getUser()==null){
			$this->strUserMsg = "<li><a href='".__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/login'>Login</a></li>";
		}
		else{
			$user= $userMan->getUser();
			$this->strUserMsg = "<li class'dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$user->Name." <b class='caret'></b></a>
			 	<ul class='dropdown-menu'>
			 		<li><a href='".__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/user/".$user->Username."'>Your Profile</a></li>
			 		<li><a href='".__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/logout'>Log Out</a></li>
			 	</ul>
			 	</li>";
		}
	}

	/**
	 * The function to set the main body panel
	 *
	 * @return null
	 */
	protected function SetController() {
		$pnlMainBody = null;
		switch (QApplication::PathInfo(0)) {
			case 'login':
				$pnlMainBody = new LoginController($this, null);
				break;
			case 'logout':
				$pnlMainBody = new LogoutController($this, null);
				break;
			case 'about':
				$pnlMainBody = new AboutController($this, null);
				break;
			case 'user':
				if(QApplication::PathInfo(1)==null){
					$pnlMainBody = new PageNotFoundController($this, null);
				}
				else{
					$pnlMainBody = new UserProfileController($this, null);
				}
			break;
			case 'campaign':
				if(QApplication::PathInfo(1)==null){
					$pnlMainBody = new PageNotFoundController($this, null);
				}
				elseif(QApplication::PathInfo(2)==null){
					$pnlMainBody = new CampaignsController($this, null);
				}
				elseif(QApplication::PathInfo(2)=='comment'){
					$pnlMainBody = new UserAddCommentController($this, null);
				}
				else{
					$pnlMainBody = new MPDetailsController($this, null);
				}
			break;
			case null:
			case '':
				$pnlMainBody = new IndexController($this, null);
				break;
			default:
				$pnlMainBody = new PageNotFoundController($this, null);
				break;
		}
		$this->strTitle = $pnlMainBody->GetPageTitle();
		return $pnlMainBody;
	}
}
Index::Run('Index', __VIEWS_PATH__ . '/index.tpl.php');

