<?php
	/**
	 * @package Controls
	 */
	class QPanel extends QBlockControl {
		///////////////////////////
		// Private Member Variables
		///////////////////////////
		protected $strTagName = 'div';
		protected $strDefaultDisplayStyle = QDisplayStyle::Block;
		protected $blnIsBlockElement = true;
		protected $blnHtmlEntities = false;

		public $txtSearch;
		public $btnGo;
		public $lblSearchMsg;

		public function __construct($objParentObject, $strControlId){
			try{
				parent::__construct($objParentObject, $strControlId);
			} catch(QCallerException $objExc){
				$objExc->IncrementOffset();
				throw $objExc;
			}

			$this->txtSearch = new QAjaxAutoCompleteTextBox($this, 'txtServerSide_Change');
			$this->txtSearch->Placeholder = "Start typing your constituency...";
			$this->txtSearch->CssClass = "form-control input-lg col-lg-8";
			$this->txtSearch->AddAction(new QEnterKeyEvent(), new QServerControlAction($this, 'btnGo_Click'));

			$this->btnGo = new QButton($this);
			$this->btnGo->Text = "Go to Constituency";
			$this->btnGo->ButtonMode = QButtonMode::Info;
			$this->btnGo->ButtonSize = QButtonSize::Large;
			$this->btnGo->AddAction(new QEnterKeyEvent(), new QServerControlAction($this, 'btnGo_Click'));
			$this->btnGo->AddAction(new QClickEvent(), new QServerControlAction($this, 'btnGo_Click'));


			if(QApplication::PathInfo(2)!=null){
				$constituency = Constituencies::LoadById(QApplication::PathInfo(2));
				if($constituency!=null){
					$this->txtSearch->Text = $constituency->Name;
				}
			}

			$this->lblSearchMsg = new IAlertLabel($this);
			$this->lblSearchMsg->AlertLabelMode = IAlertLabelMode::Danger;
			$this->lblSearchMsg->Visible = false;
		}

		public function btnGo_Click($strFormId, $strControlId, $strParameter){
			if(Constituencies::QuerySingle(QQ::Equal(QQN::Constituencies()->Name, $this->txtSearch->Text))==null){
				$this->lblSearchMsg->Text = "Sorry, we couldn't find that constituency.";
				$this->lblSearchMsg->Visible = true;
			}
			else{
				$url = __SM_SITE_ADDRESS__.__SM_URL_REWRITE__."/campaign/saverti/".Constituencies::QuerySingle(QQ::Equal(QQN::Constituencies()->Name, $this->txtSearch->Text))->Id;
				QApplication::Redirect($url);
			}
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
	}