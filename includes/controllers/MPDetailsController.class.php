<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  * Main page about the campaign, users can vote, add comments etc from here
  */


class MPDetailsController extends QPanel{

	public $strPageTitle;

	public $lblMpName;
	public $lblParty;
	public $lblPAddress;
	public $lblDAddress;
	public $lblEmail;
	public $lblConstituency;

	public $lblMpStand;
	public $lblUserStand;

	public $btnVoteFor;
	public $btnVoteAgainst;

	public $radioVote;
	public $strVote;

	public $lblConstituencyFor;
	public $lblConstituencyAgainst;

	public $dtrComments;
	public $txtCommentBox;
	public $btnCommentSubmit;

	public $strCampaign;
	public $user;
	public $campaign;
	public $constituency;

	public $strVoteNow;

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
			$this->strCampaign = $this->campaign->Name;

			// MP Details
			$this->constituency = Constituencies::LoadById(QApplication::PathInfo(2))->Id;
			$mp = Mps::LoadByConstituency($this->constituency);
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
			$this->lblConstituency->Text = "<h4>".$mp->ConstituencyObject->Name.", ".$mp->ConstituencyObject->StateObject->Name."</h4>";

			// MP's Stand on issue

			$this->lblMpStand = new QLabel($this);
			$this->lblMpStand->HtmlEntities = false;

			$mpStand = MpStandOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->MpId, $mp->Id),QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			if($mpStand == null){
				$this->lblMpStand->Text = "<h3><p class='text-center'>Undecided</p></h3>";
			}
			elseif($mpStand->Vote == true){
				$this->lblMpStand->Text = "<h3><p class='text-success text-center'>For></p></h3>";
			}
			elseif($mpStand->Vote == false){
				$this->lblMpStand->Text = "<h3><p class='text-danger text-center'>Against</p></h3>";
			}

			// User's stand on issue

			$this->lblUserStand = new QLabel($this);
			$this->lblUserStand->HtmlEntities = false;

			$this->btnVoteFor = new QButton($this);
			$this->btnVoteFor->ButtonMode = QButtonMode::Success;
			$this->btnVoteFor->Text = "For";
			$this->btnVoteFor->Visible = false;
			$this->btnVoteFor->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnVoteFor_Click'));

			$this->btnVoteAgainst = new QButton($this);
			$this->btnVoteAgainst->ButtonMode = QButtonMode::Danger;
			$this->btnVoteAgainst->Text = "Against";
			$this->btnVoteAgainst->Visible = false;
			$this->btnVoteAgainst->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnVoteAgainst_Click'));

			$userMan = new UserManagement();
			$this->user = $userMan->getUser();
			if($this->user == null){
				$this->lblUserStand->Text = "You are not logged in.";
			}
			else{
				$userStand = UsersVoteOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->UserId, $this->user->Id), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
				if($userStand == null){
					$this->lblUserStand->Text = "<h3><p class='text-center'>You haven't voted yet.</p></h3>";
					$this->btnVoteFor->Visible = true;
					$this->btnVoteAgainst->Visible = true;
					$this->strVoteNow = "Vote Now&nbsp;";
				}
				elseif($userStand->Vote == true){
					$this->lblUserStand->Text = "<h3><p class='text-success text-center'>For</p></h3>";
				}
				elseif($userStand->Vote == false){
					$this->lblUserStand->Text = "<h3><p class='text-danger text-center'>Against</p></h3>";
				}
			}

			// constituency stats

			$this->lblConstituencyFor = new QLabel($this);
			$this->lblConstituencyAgainst = new QLabel($this);

			$noPeopleFor = 0;
			$noPeopleAgainst = 0;
			$votes = UsersVoteOnCampaigns::LoadAll();
			foreach($votes as $vote){
				if($vote->User->Constituency == Constituencies::LoadById(QApplication::PathInfo(2))->Id){
					if($vote->Vote == true){
						$noPeopleFor++;
					}
					else{
						$noPeopleAgainst++;
					}
				}
			}

			$this->lblConstituencyFor->Text = $noPeopleFor;
			$this->lblConstituencyAgainst->Text = $noPeopleAgainst;

			// votes
			$this->radioVote = new QRadioButtonList($this);
			$this->radioVote->AddItem('For', 1);
			$this->radioVote->AddItem('Against', 0);
			$this->radioVote->Name = "Your Vote: ";
			$this->radioVote->AddAction(new QChangeEvent(), new QAjaxControlAction($this, 'radioVote_Change'));

			if(isset($_SESSION['vote'])){
				if($_SESSION['vote']=='for'){
					$this->radioVote->SelectedValue = 1;
				}
				else{
					$this->radioVote->SelectedValue = 0;
				}
				$this->strVote = $_SESSION['vote'];
			}

			// voting will not be visible if user has already voted

			if($this->user){
				$userStand = UsersVoteOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->UserId, $this->user->Id), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
				if($userStand!=null){
					$this->radioVote->Visible = false;
				}
			}

			// comments

			$this->txtCommentBox = new QTextBox($this);
			$this->txtCommentBox->TextMode = QTextMode::MultiLine;
			$this->txtCommentBox->Rows = 3;
			$this->txtCommentBox->Placeholder = "Type here to let your MP know your views on this issue";
			if(isset($_SESSION['comment'])){
				$this->txtCommentBox->Text = $_SESSION['comment'];
				unset($_SESSION['comment']);
			}

			$this->btnCommentSubmit = new QButton($this);
			$this->btnCommentSubmit->Text = "Submit";
			$this->btnCommentSubmit->ButtonMode = QButtonMode::Info;
			$this->btnCommentSubmit->AddAction(new QEnterKeyEvent(), new QServerControlAction($this, 'btnCommentSubmit_Click'));
			$this->btnCommentSubmit->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnCommentSubmit_Click'));



			$this->dtrComments = new QDataRepeater($this);
			$this->dtrComments->Paginator = new QPaginator($this);
			$this->dtrComments->ItemsPerPage = 10;
			$this->dtrComments->UseAjax = false;
			$this->dtrComments->Template = __VIEWS_PATH__ . '/commentfeed.tpl.php';
			$this->dtrComments->TotalItemCount = UserCommentOnCampaigns::QueryCount(QQ::Equal(QQN::UserCommentOnCampaigns()->ConstituencyId, $this->constituency));
			$this->dtrComments->DataSource = UserCommentOnCampaigns::QueryArray(QQ::Equal(QQN::UserCommentOnCampaigns()->ConstituencyId, $this->constituency), QQ::Clause($this->dtrComments->LimitClause, QQ::OrderBy(QQN::UserCommentOnCampaigns()->Date, false)));
			if($this->dtrComments->TotalItemCount == 0){
				$this->dtrComments->Paginator->Visible = false;
			}

			$this->strTemplate = __VIEWS_PATH__ . '/MPDetailsView.tpl.php';

			$this->strPageTitle = __SM_APP_NAME__." - ".$this->strCampaign." ".$this->constituency;

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

	public function btnVoteFor_Click($strFormId, $strControlId, $strParameter){
		$vote = new UsersVoteOnCampaigns();
		$vote->CampaignId = $this->campaign->Id;
		$vote->UserId = $this->user->Id;
		$vote->Vote = true;
		$vote->Date = QDateTime::Now();
		$vote->Save();
		$this->user->Constituency = Constituencies::LoadById(QApplication::PathInfo(2))->Id;
		$this->user->Save();
		QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/comment");
	}

	public function btnVoteAgainst_Click($strFormId, $strControlId, $strParameter){
		$vote = new UsersVoteOnCampaigns();
		$vote->CampaignId = $this->campaign->Id;
		$vote->UserId = $this->user->Id;
		$vote->Vote = false;
		$vote->Date = QDateTime::Now();
		$vote->Save();
		$this->user->Constituency = Constituencies::LoadById(QApplication::PathInfo(2))->Id;
		$this->user->Save();
		QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/comment");
	}

	public function btnCommentSubmit_Click($strFormId, $strControlId, $strParameter){
		if($this->user == null){
			$_SESSION['comment'] = $this->txtCommentBox->Text;
			$utils = new Utils();
			if(isset($this->strVote)){
				$_SESSION['vote'] = $this->strVote;
			}
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/login?next=".urlencode($utils->curPageURL()));
		}
		else{
			$comment = new UserCommentOnCampaigns();
			$comment->UserId = $this->user->Id;
			$comment->CampaignId = $this->campaign->Id;
			$comment->ConstituencyId = $this->constituency;
			$comment->Comment = $this->txtCommentBox->Text;
			$comment->Date = QDateTime::Now();
			$comment->Save();
			if(isset($this->strVote)){
				if($this->strVote=='for'){
					$vote = new UsersVoteOnCampaigns();
					$vote->CampaignId = $this->campaign->Id;
					$vote->UserId = $this->user->Id;
					$vote->Vote = true;
					$vote->Date = QDateTime::Now();
					$vote->Save();
					$this->user->Constituency = Constituencies::LoadById(QApplication::PathInfo(2))->Id;
					$this->user->Save();
				}
				else{
					$vote = new UsersVoteOnCampaigns();
					$vote->CampaignId = $this->campaign->Id;
					$vote->UserId = $this->user->Id;
					$vote->Vote = false;
					$vote->Date = QDateTime::Now();
					$vote->Save();
					$this->user->Constituency = Constituencies::LoadById(QApplication::PathInfo(2))->Id;
					$this->user->Save();
				}
			}
			$utilsObj = new Utils();
			QApplication::Redirect($utilsObj->curPageURL());
		}
	}

	public function radioVote_Change($strFormId, $strControlId, $strParameter){
		if($this->radioVote->SelectedValue){
			$this->strVote = 'for';
		}
		else{
			$this->strVote = 'against';
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}