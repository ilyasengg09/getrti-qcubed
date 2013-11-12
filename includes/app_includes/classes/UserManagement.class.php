<?php

class UserManagement{

	public function addSession($email){
		// create a new session in database
		$session = new UsersSessions();
		$session->UserId = Users::LoadByEmail($email)->Id;
		$session->Dat = $sessionDate = QDateTime::Now();
		$utilsObj = new Utils();
		$session->SessionKey = $sessionKey = $utilsObj->get_random_string(32);
		$session->UserAgent = $sessionUserAgent = $_SERVER['HTTP_USER_AGENT'];
		$session->Save();

		$sessionID = UsersSessions::LoadBySessionKey($sessionKey);

		// create a new session
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['sessionkey'] = $sessionKey;
		$_SESSION['date'] = $sessionDate;
		$_SESSION['useragent'] = $sessionUserAgent;
		$_SESSION['id'] = $sessionID->Id;
	}

	public function checkCookie(){
		if(!isset($_SESSION['id'])){
			return false;
		}
		$sessionid = $_SESSION['id'];

		// check if session is valid
		if(UsersSessions::LoadById($sessionid)==null){
			return false;
		}
		$session = UsersSessions::LoadById($sessionid);

		// check if useragent is correct
		if($_SESSION['useragent']==$_SERVER['HTTP_USER_AGENT'] && $_SERVER['HTTP_USER_AGENT']==$session->UserAgent){

		}
		else{
			return false;
		}

		// check if date is correct
		if($_SESSION['date']!=$session->Dat){
			return false;
		}

		// check if session key is correct
		if($_SESSION['sessionkey']!=$session->SessionKey){
			return false;
		}

		return true;
	}

	public function getUser(){
		if($this->checkCookie()){
			$userSession = UsersSessions::LoadBySessionKey($_SESSION['sessionkey']);
			return $userSession->User;
		}
		else{
			return null;
		}
	}
}