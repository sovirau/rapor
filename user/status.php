<?php
session_start();
error_reporting(0);
if (isset($_SESSION['level']))
{

if($_SESSION['level'] == "siswa")
{
header('location:siswa/');
}
else if ($_SESSION['level'] == "guru")
{
header('location:guru/');
}
}
?>
