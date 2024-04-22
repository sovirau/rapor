<?php
error_reporting(0);

switch ($_GET['std']) {

	case 'dashboard':
		include "home.php";
		break;

	case 'details':
		include "detailkelas.php";
		break;

	case 'data_kompetensi':
		include "data_kompetensi.php";
		break;

	case 'nilai_view':
		include "nilai_view.php";
		break;

	case 'edit_profil':
		include "edit_profil.php";
		break;

	case 'edit_password':
		include "update_password.php";
		break;

	case 'nilai':
		include "nilai.php";
		break;

	default:
		include "home.php";
		break;
}
?>