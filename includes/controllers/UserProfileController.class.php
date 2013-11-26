<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  * User profile page
  */


class UserProfileController extends QPanel{

	public $strPageTitle;

	public $lblName;
	public $lblUsername;
	public $strImage;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$userpathinfo = QApplication::PathInfo(1);
		if(Users::LoadByUsername($userpathinfo)==null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}
		else{
			$user = Users::LoadByUsername($userpathinfo);
			$this->lblName = new QLabel($this);
			$this->lblName->Text = $user->Name;
			$this->lblUsername = new QLabel($this);
			$this->lblUsername->Text = $user->Username;
			$imgSize = 250;
			$imgDefault = "http://getrti.co.in/assets/images/default-avatar.png";
			$grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($user->Email))) . "?d=" . urlencode($imgDefault) . "&s=" . $imgSize;
			$this->strImage = "<img src='".$grav_url."'/>";

			$this->strTemplate = __VIEWS_PATH__ . '/UserProfileView.tpl.php';
			$this->strPageTitle = __SM_APP_NAME__." - ".$user->Name;
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}