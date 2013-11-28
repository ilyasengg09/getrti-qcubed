<?php

/*
  * Created by Saurav Modak
  * saurav at linuxb dot in
  * Main page about the campaign, users can vote, add comments etc from here
  */


class MPDetailsController extends QPanel{

	public $strPageTitle;

	public $campaign;
	public $constituency;
	public $mp;
	public $user;

	public $lblMsg;

	public $lblMpName;
	public $lblParty;
	public $lblPAddress;
	public $lblDAddress;
	public $lblEmail;
	public $lblConstituency;

	public $lblMpStand;

	public $lblConstituencyFor;
	public $lblConstituencyAgainst;

	public $dtrComments;

	public $txtCommentBox;
	public $btnCommentSubmit;
	public $radioVote;
	public $strVote = "undecided";

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		// check if campaign is valid
		$this->campaign = Campaigns::LoadBySlug(QApplication::PathInfo(1));
		if($this->campaign == null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}

		// check if constituency is valid
		$this->constituency = Constituencies::Load(QApplication::PathInfo(2));
		if($this->constituency == null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}

		else{

			$this->lblMsg = new IAlertLabel($this);
			$this->lblMsg->Visible = false;
			$this->lblMsg->HtmlEntities = false;

			// MP Details
			$this->mp = Mps::LoadByConstituency($this->constituency->Id);
			$this->lblMpName = new QLabel($this);
			$this->lblMpName->HtmlEntities = false;
			$this->lblParty = new QLabel($this);
			$this->lblPAddress = new QLabel($this);
			$this->lblDAddress = new QLabel($this);
			$this->lblEmail = new QLabel($this);
			$this->lblConstituency = new QLabel($this);
			$this->lblConstituency->HtmlEntities = false;

			$this->lblMpName->Text = "<h3>".$this->mp->Name."</h3>";
			$this->lblParty->Text = $this->mp->Party;
			$this->lblPAddress->Text = $this->mp->PermanentAddress." ".$this->mp->PermanentPhone;
			$this->lblDAddress->Text = $this->mp->DelhiAddress." ".$this->mp->DelhiPhone;
			$this->lblEmail->Text = "Email: ".$this->mp->Email;
			$this->lblConstituency->Text = "<h4>".$this->mp->ConstituencyObject->Name.", ".$this->mp->ConstituencyObject->StateObject->Name."</h4>";

			// MP's Stand on issue

			$this->lblMpStand = new QLabel($this);
			$this->lblMpStand->HtmlEntities = false;

			$mpStand = MpStandOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::MpStandOnCampaigns()->MpId, $this->mp->Id),QQ::Equal(QQN::MpStandOnCampaigns()->CampaignId, $this->campaign->Id)));
			if($mpStand == null){
				$this->lblMpStand->Text = "<h3><p class='text-center'>Undecided</p></h3>";
			}
			elseif($mpStand->Vote == true){
				$this->lblMpStand->Text = "<h3><p class='text-success text-center'>For></p></h3>";
			}
			elseif($mpStand->Vote == false){
				$this->lblMpStand->Text = "<h3><p class='text-danger text-center'>Against</p></h3>";
			}

			// constituency stats

			$this->lblConstituencyFor = new QLabel($this);
			$this->lblConstituencyAgainst = new QLabel($this);

			$noPeopleFor = 0;
			$noPeopleAgainst = 0;
			$votes = UsersVoteOnCampaigns::LoadArrayByConstituencyId($this->constituency->Id);
			foreach($votes as $vote){
				if($vote->Vote == true){
					$noPeopleFor++;
				}
				else{
					$noPeopleAgainst++;
				}
			}
			$this->lblConstituencyFor->Text = $noPeopleFor;
			$this->lblConstituencyAgainst->Text = $noPeopleAgainst;

			// comments

			$this->dtrComments = new QDataRepeater($this);
			$this->dtrComments->Paginator = new QPaginator($this);
			$this->dtrComments->ItemsPerPage = 10;
			$this->dtrComments->UseAjax = false;
			$this->dtrComments->Template = __VIEWS_PATH__ . '/commentfeed.tpl.php';
			$this->dtrComments->TotalItemCount = UserCommentOnCampaigns::QueryCount(QQ::Equal(QQN::UserCommentOnCampaigns()->ConstituencyId, $this->constituency->Id));
			$this->dtrComments->DataSource = UserCommentOnCampaigns::QueryArray(QQ::Equal(QQN::UserCommentOnCampaigns()->ConstituencyId, $this->constituency->Id), QQ::Clause($this->dtrComments->LimitClause, QQ::OrderBy(QQN::UserCommentOnCampaigns()->Date, false)));
			if($this->dtrComments->TotalItemCount == 0){
				$this->dtrComments->Paginator->Visible = false;
			}

			// comment box

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

			// votes
			$this->radioVote = new QRadioButtonList($this);
			$this->radioVote->AddItem('For', 1);
			$this->radioVote->AddItem('Against', 0);
			$this->radioVote->Name = "Your Vote: ";
			$this->radioVote->AddAction(new QChangeEvent(), new QAjaxControlAction($this, 'radioVote_Change'));

			// voting and comments will not be visible if user has already voted
			$userMan = new UserManagement();
			$this->user = $userMan->getUser();

			if($this->user){
				$userStand = UsersVoteOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id), QQ::Equal(QQN::UsersVoteOnCampaigns()->UserId, $this->user->Id)));
				if($userStand!=null){
					$this->radioVote->Visible = false;
					$this->txtCommentBox->Visible = false;
					$this->btnCommentSubmit->Visible = false;
				}
			}

			$this->strTemplate = __VIEWS_PATH__ . '/MPDetailsView.tpl.php';
			$this->strPageTitle = __SM_APP_NAME__." - ".$this->campaign->Name." - ".$this->constituency->Name;

		}

	}

	public function btnCommentSubmit_Click($strFormId, $strControlId, $strParameter){
		$error = 0;
		$utilsObj = new Utils();
		$this->lblMsg->Text="<ul>";
		if($this->user == null){
			$_SESSION['comment'] = $this->txtCommentBox->Text;
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/login?next=".urlencode($utilsObj->curPageURL()));
		}
		elseif($this->txtCommentBox->Text == ""){
			$this->lblMsg->Text .= "<li>Comment cannot be empty</li>";
			$error = 1;
		}
		elseif($this->strVote == "undecided"){
			$this->lblMsg->Text .= "<li>Please vote for or against</li>";
			$error = 1;
		}

		$userVote = UsersVoteOnCampaigns::QuerySingle(QQ::AndCondition(QQ::Equal(QQN::UsersVoteOnCampaigns()->UserId, $this->user->Id), QQ::Equal(QQN::UsersVoteOnCampaigns()->CampaignId, $this->campaign->Id)));
		if($userVote!=null){
			$this->lblMsg->Text .= "<li>You can vote only once.</li>";
			$error = 1;
		}
		elseif($error==0){
			// add comment
			$comment = new UserCommentOnCampaigns();
			$comment->UserId = $this->user->Id;
			$comment->CampaignId = $this->campaign->Id;
			$comment->ConstituencyId = $this->constituency->Id;
			$comment->Comment = $this->txtCommentBox->Text;
			$comment->Date = QDateTime::Now();
			$comment->Save();

			// add vote
			if($this->strVote=='for'){
				$vote = new UsersVoteOnCampaigns();
				$vote->CampaignId = $this->campaign->Id;
				$vote->UserId = $this->user->Id;
				$vote->ConstituencyId = $this->constituency->Id;
				$vote->Vote = true;
				$vote->Date = QDateTime::Now();
				$vote->Save();
			}
			elseif($this->strVote=='against'){
				$vote = new UsersVoteOnCampaigns();
				$vote->CampaignId = $this->campaign->Id;
				$vote->UserId = $this->user->Id;
				$vote->ConstituencyId = $this->constituency->Id;
				$vote->Vote = false;
				$vote->Date = QDateTime::Now();
				$vote->Save();
			}
			QApplication::Redirect($utilsObj->curPageURL());
		}
		if($error){
			$this->lblMsg->Text.="</ul>";
			$this->lblMsg->Visible = true;
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
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