<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  *
  * Displays info about the campaign, name, desc, MP's Stand, Users' stand etc
  */


class CampaignsController extends QPanel{

	public $strPageTitle;

	public $lblMpFor;
	public $lblMpAgainst;
	public $lblMpUndecided;

	public $lblUsersFor;
	public $lblUsersAgainst;

	public $campaign;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$this->campaign = Campaigns::LoadBySlug(QApplication::PathInfo(1));
		if($this->campaign == null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}
		else{

			// MP Stats

			$this->lblMpFor = new QLabel($this);
			$this->lblMpFor->HtmlEntities = false;
			$this->lblMpFor->Text = "<h3>";

			$this->lblMpAgainst = new QLabel($this);
			$this->lblMpAgainst->HtmlEntities = false;
			$this->lblMpAgainst->Text = "<h3>";

			$this->lblMpUndecided = new QLabel($this);
			$this->lblMpUndecided->HtmlEntities = false;
			$this->lblMpUndecided->Text = "<h3>";

			$this->lblMpFor->Text.= $mpFor = MpStandOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->Vote, true), QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->lblMpFor->Text.="</h3>";

			$this->lblMpAgainst->Text.= $mpAgainst = MpStandOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->Vote, false), QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->lblMpAgainst->Text.="</h3>";

			$this->lblMpUndecided->Text.= Mps::CountAll() - ($mpFor+$mpAgainst);
			$this->lblMpUndecided->Text.="</h3>";

			// Users Stats

			$this->lblUsersFor = new QLabel($this);
			$this->lblUsersFor->HtmlEntities = false;
			$this->lblUsersFor->Text = "<h3>";

			$this->lblUsersAgainst = new QLabel($this);
			$this->lblUsersAgainst->HtmlEntities = false;
			$this->lblUsersAgainst->Text = "<h3>";

			$this->lblUsersFor->Text.=UsersVoteOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->Vote, true), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->lblUsersFor->Text.="</h3>";

			$this->lblUsersAgainst->Text.=UsersVoteOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->Vote, false), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->lblUsersAgainst->Text.="</h3>";

			$this->strTemplate = __VIEWS_PATH__ . '/CampaignsView.tpl.php';

			$this->strPageTitle = __SM_APP_NAME__." - ".$this->campaign->Name;
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}