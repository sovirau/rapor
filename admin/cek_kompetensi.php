<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:../");
}
require_once('config.php');

  $mapel = $_GET['mapel'];

  $sql = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    where a.id_pelajaran= '$mapel'");
  echo "<option></option>";
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['id_bab']."'>".$tampil['nama_bab']."</option>";
  }
?>