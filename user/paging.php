<?php
error_reporting(0);

switch ($_GET['paging']) {

	case 'dashboard':
		include "home.php";
		break;

	case 'details':
		include "detailkelas.php";
		break;

	case 'data_kompetensi':
		include "data_kompetensi.php";
		break;

	case 'nilai':
		include "nilai_old.php";
		break;

	default:
		include "home.php";
		break;
}
?>