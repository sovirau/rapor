<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
require_once('config.php');

  $level = $_GET['level'];

  if($level == 'guru'){
  $sql = mysql_query("SELECT * from tb_guru");
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['kode_guru']."'>".$tampil['nama_guru']."</option>";
  } 
  }elseif ($level == 'siswa') {
  $sqla = mysql_query("SELECT * from tb_siswa");
  while ($tampila = mysql_fetch_array($sqla)){
    echo "<option value ='".$tampila['nis']."'>".$tampila['nama_siswa']."</option>";
  }
  }
?>