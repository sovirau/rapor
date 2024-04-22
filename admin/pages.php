<?php
error_reporting(0);

switch ($_GET['pages']) {

	case 'dashboard':
		include "dashboard.php";
		break;

	case 'default':
		include "home.php";
		break;

	case 'logout':
		include "logout.php";
		break;

	case 'dataguru':
		include "dataguru.php";
		break;

	case 'editguru':
		include "editguru.php";
		break;

	case 'datasiswa':
		include "datasiswa.php";
		break;

	case 'editsiswa':
		include "datasiswa_edit.php";
		break;

	case 'datajurusan':
		include "datajurusan.php";
		break;	

	case 'editjurusan':
		include "datajurusan_edit.php";
		break;

	case 'datakelas':
		include "datakelas.php";
		break;

	case 'datapelajaran':
		include "datapelajaran.php";
		break;

	case 'editpelajaran':
		include "datapelajaran_edit.php";
		break;

	case 'datapengajar':
		include "datapengajar.php";
		break;

	case 'editpengajar':
		include "datapengajar_edit.php";
		break;

	case 'login':
		include "default.php";
		break;

	case 'datauser':
		include "datauser.php";
		break;

	case 'datanilai':
		include "datanilai.php";
		break;

	case 'edituserguru':
		include "edituserguru.php";
		break;

	case 'editusersiswa':
		include "editusersiswa.php";
		break;

	case 'datanilai':
		include "datanilai.php";
		break;

	default:
		include "dashboard.php";
		break;
}
?>