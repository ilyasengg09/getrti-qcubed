<?php

class UserAddCommentController extends QPanel{

	public $strPageTitle;

	public $lblMsg;
	public $txtComment;
	public $btnSubmit;
	public $lblSkip;

	public $campaign;
	public $userMan;

	public function __construct($objParentObject, $strControlId){
		try{
			parent::__construct($objParentObject, $strControlId);
		} catch(QCallerException $objExc){
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$this->userMan = new UserManagement();
		if($this->userMan->getUser()==null){
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/login");
		}
		$this->campaign = Campaigns::LoadBySlug(QApplication::PathInfo(1));
		if($this->campaign == null){
			$this->strTemplate = __VIEWS_PATH__ . '/PageNotFoundView.tpl.php';
			$this->strPageTitle = "Page Not Found";
		}
		else{
			$this->lblMsg = new IAlertLabel($this);
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Success;
			$this->lblMsg->Text = "Your vote has been cast. Please leave your thoughts below.";
			$this->txtComment = new QTextBox($this);
			$this->txtComment->Placeholder = "I voted for/against the issue because..";
			$this->txtComment->TextMode = QTextMode::MultiLine;
			$this->txtComment->Rows = 5;
			$this->btnSubmit = new QButton($this);
			$this->btnSubmit->ButtonMode = QButtonMode::Success;
			$this->btnSubmit->Text = "Submit";
			$this->btnSubmit->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnSubmit_Click'));
			$this->lblSkip = new QLabel($this);
			$this->lblSkip->HtmlEntities = false;
			$this->lblSkip->Text = "<a href='".__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/".$this->userMan->getUser()->Constituency."'>Skip</a>";

			$this->strTemplate = __VIEWS_PATH__ . '/UserAddCommentView.tpl.php';

			$this->strPageTitle = __SM_APP_NAME__." - Logout";
		}

	}

	public function btnSubmit_Click($strFormId, $strControlId, $strParameter){
		if($this->txtComment->Text == null){
			$this->lblMsg->AlertLabelMode = IAlertLabelMode::Danger;
			$this->lblMsg->Text = "Comment is required";
		}
		else{
			$comment = new UserCommentOnCampaigns();
			$comment->UserId = $this->userMan->getUser()->Id;
			$comment->ConstituencyId = $this->userMan->getUser()->Constituency;
			$comment->CampaignId = $this->campaign->Id;
			$comment->Comment = $this->txtComment->Text;
			$comment->Date = QDateTime::Now();
			$comment->Save();
			QApplication::Redirect(__SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/".$this->userMan->getUser()->Constituency);
		}
	}

	public function GetPageTitle() {
		return $this->strPageTitle;
	}
}