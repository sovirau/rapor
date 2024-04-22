<?php
session_start();
if(!isset($_SESSION['username'])){
  header("location:../");
}
require_once('config.php');


$nama_siswa = $_SESSION['username'];
$siswa = mysql_query("SELECT a.*, b.* from tb_siswa a 
                    inner join tb_login b on a.nis = b.kode_user
                    where b.username = '$nama_siswa'");
$siswarow = mysql_fetch_array($siswa);
$id = $siswarow['nis'];

  $mapel = $_GET['mapel'];

  $cb = mysql_query("SELECT * from tb_siswa where nis = '$id'");
  $rs = mysql_fetch_array($cb);

  $id_kelas = $rs['id_kelas'];

  $sql = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    where a.id_kelas = '$id_kelas' and a.id_pelajaran= '$mapel'");
  echo "<option></option>";
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['id_bab']."'>".$tampil['nama_bab']."</option>";
  }
?>