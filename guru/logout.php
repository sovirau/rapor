<?php  
error_reporting(0);
session_start();
require_once "config.php";

//unset ($_SESSION ['username']);
//header ("location:index.php?status=Anda sudah Keluar");

if($_SESSION['username']){
	session_destroy();
	header('Location:../');
}else{
	//session_destroy();
	//header('Location:index.php?submit=login');
}
?>