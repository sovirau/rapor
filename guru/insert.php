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

if (isset($_POST['submit2'])) {

$amt = $_POST['jumlah'];

    $sql = mysql_query("SELECT * from tb_nilai where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["pelajaran"]."'and '".$_POST["bab"]."'");
    $result = mysql_num_rows($sql);

    if($result >= 1){
        $query = "UPDATE tb_nilai set "; //split the mysql_query
        for($no=1; $no<=$amt; $no++) {
        $query .= "nilai_p = '".$_POST["nilai_p$no"]."', nilai_k = '".$_POST["nilai_k$no"]."', nilai_s = '".$_POST["nilai_s$no"]."' where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["pelajaran"]."' and id_bab = '".$_POST["bab"]."', ";
        }
        $query  = substr($query, 0, strlen($query)-2);
        $update = mysql_query($query); // Execute the mysql_query
        if($update){
            echo '<div id = "result"><div class="alert alert-success alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span class="glyphicon glyphicon-ok"></span> Ubah Data Sukses</div></div>';
    }
        else {
            echo '<div id = "result"><div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Ubah Data Gagal</div></div>';
        }
    }
else{
        $qry = "INSERT INTO tb_nilai(nis, id_pelajaran, id_bab, id_kelas, nilai_p, nilai_k, nilai_s, addedby, updated) VALUES "; // Split the mysql_query
        for($no=1; $no<=$amt; $no++) {
            $qry .= "('".$_POST["nis$no"]."', '".$_POST["pelajaran"]."', '".$_POST["bab"]."', '".$_POST["id_kelas"]."', '".$_POST["nilai_p$no"]."', '".$_POST["nilai_k$no"]."', '".$_POST["nilai_s$no"]."', '$id', 'now()'), "; // loop the mysql_query values to avoid more server loding time
        }
        $qry    = substr($qry, 0, strlen($qry)-2);
        $insert = mysql_query($qry); // Execute the mysql_query
    // Redirect for each cases
    if($insert) {
            echo '<div id = "result"><div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Tambah Data Sukses</div></div>';
    }
    else {
            echo '<div id = "result"><div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Tambah Data Gagal</div></div>';
    }
}
}
?>