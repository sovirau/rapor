<?php  
session_start();
require_once "config.php";

//unset ($_SESSION ['username']);
//header ("location:index.php?status=Anda sudah Keluar");

if($_SESSION['admin']){
	session_destroy();
	header('Location:index.php?submit=logout');
}else{
	session_destroy();
	header('Location:index.php?submit=login');
}
?>