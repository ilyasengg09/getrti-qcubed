<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  *
  * Displays info about the campaign, name, desc, MP's Stand, Users' stand etc
  */


class CampaignsController extends QPanel{

	public $strPageTitle;

	public $strMpFor;
	public $strMpAgainst;
	public $strMpUndecided;

	public $strUsersFor;
	public $strUsersAgainst;

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

			$this->strMpFor = $mpFor = MpStandOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->Vote, true), QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->strMpAgainst = $mpAgainst = MpStandOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->Vote, false), QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->strMpUndecided = Mps::CountAll() - ($mpFor+$mpAgainst);

			// Users Stats

			$this->strUsersFor = UsersVoteOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->Vote, true), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
			$this->strUsersAgainst = UsersVoteOnCampaigns::QueryCount(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->Vote, false), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));

			$this->strTemplate = __VIEWS_PATH__ . '/CampaignsView.tpl.php';

			$this->strPageTitle = __SM_APP_NAME__." - ".$this->campaign->Name;
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}