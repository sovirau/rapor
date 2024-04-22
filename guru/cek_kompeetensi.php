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

  $kelas = $_GET['kelas'];

  $sql = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    inner join tb_guru d on a.kode_guru = d.kode_guru
                    where a.kode_guru = '$id' and a.id_kelas = '$kelas'
                    order by c.nama_pelajaran");
  echo "<option></option>";
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['id_pelajaran']."'>".$tampil['nama_pelajaran']."</option>";
  }
?>