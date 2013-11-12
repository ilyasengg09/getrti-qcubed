<?php

	// classes
	QApplicationBase::$ClassFile['utils'] = __APP_INCLUDES__.'/classes/Utils.class.php';
	QApplicationBase::$ClassFile['usermanagement'] = __APP_INCLUDES__.'/classes/UserManagement.class.php';

	// templates
	QApplicationBase::$ClassFile['headerpanel'] = __CONTROLLERS_PATH__ . '/templates/HeaderPanel.class.php';
	QApplicationBase::$ClassFile['footerpanel'] = __CONTROLLERS_PATH__ . '/templates/FooterPanel.class.php';

	// controllers
	QApplicationBase::$ClassFile['examplecontroller'] = __CONTROLLERS_PATH__ . '/ExampleController.class.php';
	QApplicationBase::$ClassFile['pagenotfoundcontroller'] = __CONTROLLERS_PATH__ . '/PageNotFoundController.class.php';
	QApplicationBase::$ClassFile['welcomecontroller'] = __CONTROLLERS_PATH__ . '/WelcomeController.class.php';
	QApplicationBase::$ClassFile['logincontroller'] = __CONTROLLERS_PATH__ . '/LoginController.class.php';
	QApplicationBase::$ClassFile['logoutcontroller'] = __CONTROLLERS_PATH__ . '/LogoutController.class.php';