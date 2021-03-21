<?php

if (! defined ( 'APP_NAME' ))
	define ( 'APP_NAME', '/rayodent/' );

if (! defined ( 'APP_PATH' ))
	define ( 'APP_PATH', $_SERVER ['DOCUMENT_ROOT'] . APP_NAME );

if (! defined ( 'WEB_PATH' ))
	define ( 'WEB_PATH', 'http://' . $_SERVER ['HTTP_HOST'] . APP_NAME );


include_once APP_PATH . 'conf/init.php';

?>
