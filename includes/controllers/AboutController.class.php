<?php

	/*
 	 * Created by Saurav Modak
 	 * saurav at linuxb dot in
	 *
	 * Contains info about project volunteers
 	 */

class AboutController extends QPanel{

	public $strPageTitle;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$this->strTemplate = __VIEWS_PATH__ . '/AboutView.tpl.php';

		$this->strPageTitle = __SM_APP_NAME__." - About";
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}