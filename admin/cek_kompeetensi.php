<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:../");
}
require_once('config.php');
  $kelas = $_GET['kelas'];

  $sql = mysql_query("SELECT a.*, b.*, c.* from tb_masterprod a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    where a.id_kelas = '$kelas'
                    order by c.nama_pelajaran");
  echo "<option></option>";
  while ($tampil = mysql_fetch_array($sql)){
  	echo "<option value ='".$tampil['id_pelajaran']."'>".$tampil['nama_pelajaran']."</option>";
  }
?>