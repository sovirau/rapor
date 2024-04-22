<head>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
  $("#kelas").change(function(){
    var kelas = $("#kelas").val();
    $.ajax({
        url: "cek_kompeetensi.php",
        data: "kelas="+kelas,
        cache: false,
        success: function(msg){
            $("#mapel").html(msg);
        }
    });
  });
});
</script>
</head>
<?php
session_start();
if(!isset($_SESSION['kodeguru'])){
  header("location:../");
}
require_once('config.php');

$kode_guru = $_SESSION['kodeguru'];

$kelas=$_GET['id_kelas'];
$sql = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_produktif a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    inner join tb_guru d on a.kode_guru = d.kode_guru
                    where a.id_kelas='$kelas' and a.kode_guru = 'vin'
                    order by b.nama_kelas");
$tampil = mysql_fetch_array($sql);
$sqlt = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas");

if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
        $kelas = $_POST['kelas'];
        $mapel = $_POST['mapel'];
        $kompetensi = $_POST['kompetensi'];
        $kode_guru = $_POST['kode_guru'];

        $sqltambah = mysql_query("SELECT * from tb_bab where id_pelajaran = '$mapel' and id_kelas = '$kelas' and kompetensi = '$kompetensi'");
        $cekplus = mysql_num_rows($sqltambah);

        if($cekplus){
            echo "<script> alert('Maaf, Data Yang Anda Masukkan Sudah Ada'); </script>";
            echo "<script> document.location = 'index.php?pages=data_kompetensi'; </script>";
        } else {
            mysql_query("INSERT into tb_bab (id_pelajaran, id_kelas, kode_guru, nama_bab) values ('$mapel', '$kelas', '$kode_guru', '$kompetensi')");
            echo "<script> alert('Data berhasil ditambah'); </script>";
            echo "<script> document.location = 'index.php?pages=data_kompetensi'; </script>";
        }
     }
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Data Kompetensi</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data Kompetensi
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Nama Kelas</th>
                                            <th style="text-align:center">Mapel</th>
                                            <th style="text-align:center">Kompetensi</th>
                                            <th style="text-align:center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; while($row = mysql_fetch_array($sqlt)){?>
                                        <tr>
                                            <td style="text-align:center"><?php echo $row['nama_kelas']; ?></td>
                                            <td style="text-align:center"><?php echo $row['nama_pelajaran']; ?></td>
                                            <td style="text-align:center"><?php echo $row['nama_bab']; ?></td>
                                            <td style="text-align:center"><?php echo $row['nama_bab']; ?></td>
                                        </tr>
                                    <?php $no++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
                    <!--end div-->
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->