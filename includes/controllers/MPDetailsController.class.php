<?php

class MPDetailsController extends QPanel{

	public $strPageTitle;

	public $txtSearch;
	public $btnGo;
	public $lblMpName;
	public $lblParty;
	public $lblPAddress;
	public $lblDAddress;
	public $lblEmail;
	public $lblConstituency;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$campaign = Campaigns::LoadBySlug(QApplication::PathInfo(1));
		if($campaign == null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}
		else{
			// constituency search box
			$this->txtSearch = new QAjaxAutoCompleteTextBox($this, 'txtServerSide_Change');
			$this->txtSearch->Placeholder = "Start typing your constituency...";
			$this->txtSearch->CssClass = "col-lg-8";

			$this->btnGo = new QButton($this);
			$this->btnGo->Text = "Go to your constituency";
			$this->btnGo->ButtonMode = QButtonMode::Info;
			$this->btnGo->ButtonSize = QButtonSize::Small;
			$this->btnGo->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnGo_Click'));

			$this->strTemplate = __VIEWS_PATH__ . '/MPDetailsView.tpl.php';

			$this->strPageTitle = __SM_APP_NAME__." - ".$campaign->Name;

			// MP Details
			$mp = Mps::LoadByConstituency(Constituencies::LoadById(QApplication::PathInfo(2))->Id);
			$this->lblMpName = new QLabel($this);
			$this->lblMpName->HtmlEntities = false;
			$this->lblParty = new QLabel($this);
			$this->lblPAddress = new QLabel($this);
			$this->lblDAddress = new QLabel($this);
			$this->lblEmail = new QLabel($this);
			$this->lblConstituency = new QLabel($this);
			$this->lblConstituency->HtmlEntities = false;

			$this->lblMpName->Text = "<h3>".$mp->Name."</h3>";
			$this->lblParty->Text = $mp->Party;
			$this->lblPAddress->Text = $mp->PermanentAddress." ".$mp->PermanentPhone;
			$this->lblDAddress->Text = $mp->DelhiAddress." ".$mp->DelhiPhone;
			$this->lblEmail->Text = "Email: ".$mp->Email;
			$this->lblConstituency->Text = "<h3>".$mp->ConstituencyObject->Name.", ".$mp->ConstituencyObject->StateObject->Name."</h3>";
		}

	}

	public function btnGo_Click($strFormId, $strControlId, $strParameter){
		$url = __SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/".Constituencies::QuerySingle(QQ::Equal(QQN::Constituencies()->Name, $this->txtSearch->Text))->Id;
		QApplication::Redirect($url);
	}

	public function txtServerSide_change($strParameter){
		$objMemberArray = Constituencies::QueryArray(
			QQ::OrCondition(
				QQ::Like(QQN::Constituencies()->Name, $strParameter . '%')
			),
			QQ::Clause(QQ::OrderBy(QQN::Constituencies()->Name))
		);
		$result = array();
		foreach($objMemberArray as $objMember){
			$result[] = $objMember->Name;
		}
		return $result;
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}