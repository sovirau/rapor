<?php
session_start();
if(!isset($_SESSION['username'])){
  header("location:../");
}
require_once('config.php');

$kode_guru = $_SESSION['username'];
$guru = mysql_query("SELECT a.*, b.* from tb_guru a 
                    inner join tb_login b on a.kode_guru = b.kode_user
                    where b.username = '$kode_guru'");
$gururow = mysql_fetch_array($guru);
$id = $gururow['kode_guru'];

  $mapel = $_GET['mapel'];

  $sql = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    where a.kode_guru = '$id' and a.id_pelajaran= '$mapel'");
  echo "<option></option>";
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['id_bab']."'>".$tampil['nama_bab']."</option>";
  }
?>