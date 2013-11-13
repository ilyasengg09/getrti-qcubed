<?php

	// classes
	QApplicationBase::$ClassFile['utils'] = __APP_INCLUDES__.'/classes/Utils.class.php';
	QApplicationBase::$ClassFile['usermanagement'] = __APP_INCLUDES__.'/classes/UserManagement.class.php';

	// templates
	QApplicationBase::$ClassFile['headerpanel'] = __CONTROLLERS_PATH__ . '/templates/HeaderPanel.class.php';
	QApplicationBase::$ClassFile['footerpanel'] = __CONTROLLERS_PATH__ . '/templates/FooterPanel.class.php';

	// controllers
	QApplicationBase::$ClassFile['pagenotfoundcontroller'] = __CONTROLLERS_PATH__ . '/PageNotFoundController.class.php';
	QApplicationBase::$ClassFile['logincontroller'] = __CONTROLLERS_PATH__ . '/LoginController.class.php';
	QApplicationBase::$ClassFile['logoutcontroller'] = __CONTROLLERS_PATH__ . '/LogoutController.class.php';
	QApplicationBase::$ClassFile['userprofilecontroller'] = __CONTROLLERS_PATH__ . '/UserProfileController.class.php';
	QApplicationBase::$ClassFile['campaignscontroller'] = __CONTROLLERS_PATH__ . '/CampaignsController.class.php';
	QApplicationBase::$ClassFile['mpdetailscontroller'] = __CONTROLLERS_PATH__ . '/MPDetailsController.class.php';