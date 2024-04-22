<?php
error_reporting(0);

switch ($_GET['pages']) {

	case 'dashboard':
		include "home.php";
		break;

	case 'details':
		include "detailkelas.php";
		break;

	case 'data_kompetensi':
		include "data_kompetensi.php";
		break;

	case 'nilaiold':
		include "nilai_old.php";
		break;

	case 'edit_profil':
		include "edit_profil.php";
		break;

	case 'home':
		include "default.php";
		break;

	case 'exit':
		include "y.php";
		break;

	case 'logout':
		include "logout.php";
		break;

	case 'print':
		include "cetak.php";
		break;

	case 'nilai':
		include "nilai_new.php";
		break;

	default:
		include "home.php";
		break;
}
?>