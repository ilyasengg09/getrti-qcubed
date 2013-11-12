<?php

class LogoutController extends QPanel{

	public $strPageTitle;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$userMan = new UserManagement();
		if($userMan->getUser()==null){
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/login");
		}

		$session = UsersSessions::LoadBySessionKey($_SESSION['sessionkey']);
		$session->Delete();
		session_destroy();

		$this->strTemplate = __VIEWS_PATH__ . '/LogoutView.tpl.php';

		$this->strPageTitle = __SM_APP_NAME__." - Logout";
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}