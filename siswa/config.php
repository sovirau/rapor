<?php
  $host = 'localhost';
  $user ='root';
  $pass = '';
  $db = 'nilai_akademik';

  $koneksi = mysql_connect($host, $user, $pass);

  $koneksi_database = mysql_select_db($db);
?>