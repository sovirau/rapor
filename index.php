<?php
error_reporting(0);

switch ($_GET['url']) {

	case 'index':
		include "user/default2.php";
		break;

	case 'login':
		include "user/login.php";
		break;

	case 'status':
		include "user/status.php";
		break;

	default:
		include "user/default2.php";
		break;
}
?>