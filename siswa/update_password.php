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

$sql = mysql_query("SELECT a.*, b.*, c.*, d.* from tb_siswa a 
    inner join tb_guru b on a.kode_guru = b.kode_guru
    inner join tb_jurusan c on a.id_jurusan = c.id_jurusan
    inner join tb_kelas d on a.id_kelas = d.id_kelas
    where a.nis = '$id'");
$row = mysql_fetch_row($sql);

/*echo "<pre>";
print_r($row);
echo "</pre>"*/
?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Profil</h4>

                </div>

            </div>
            <div class="row">
                <form id="id_form" action="?pages=edit_password&aksi=edit" method="post">
                <input type="hidden" name="nis" value="<?php echo $row['1'];?>">
                <div class="col-md-4">
                    <img class="img-responsive img-rounded" src="assets/img/<?php echo $row['7']; ?>" >
                    <br>
                    <h1>&nbsp;&nbsp;<?php echo $row['2']; ?></h1><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?std=edit_password&nis=<?php echo $row['1']; ?>"><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-fw fa-check"></i>&nbsp;Simpan</button></a><br>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->