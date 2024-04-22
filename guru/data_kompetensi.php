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

$kelas=$_GET['id_kelas'];
$sql = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru, e.* from tb_masterprod a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    inner join tb_guru d on a.kode_guru = d.kode_guru
                    inner join tb_login e on a.kode_guru = e.kode_user
                    where a.id_kelas='$kelas' and e.kode_user = '$kode_guru'
                    order by b.nama_kelas");
$tampil = mysql_fetch_array($sql);
$sqlt = mysql_query("SELECT a.*, b.*, c.*, e.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    inner join tb_login e on a.kode_guru = e.kode_user
                    where e.kode_user = '$id'
                    order by c.nama_kelas ");

if(@$_GET['aksi'] == 'tambah'){
        $kelas = $_POST['kelas'];
        $mapel = $_POST['mapel'];
        $kompetensi = $_POST['kompetensi'];
        $kodeguru = $_POST['kode_guru'];

        $sqltambah = mysql_query("SELECT * from tb_bab where id_pelajaran = '$mapel' and id_kelas = '$kelas' and kompetensi = '$kompetensi'");
        $cekplus = mysql_num_rows($sqltambah);

        if($cekplus){
            echo "<script> alert('Maaf, Data Yang Anda Masukkan Sudah Ada'); </script>";
            echo "<script> document.location = '?pages=data_kompetensi'; </script>";
        } else {
            mysql_query("INSERT into tb_bab (id_pelajaran, id_kelas, kode_guru, nama_bab) values ('$mapel', '$kelas', '$id', '$kompetensi')");
            echo "<script> alert('Data berhasil ditambah'); </script>";
            echo "<script> document.location = '?pages=data_kompetensi'; </script>";
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
                <div class="col-md-6">
                    <!--    Bordered Table  -->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Data Kompetensi Baru
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form id="id_form" action="?pages=data_kompetensi&aksi=tambah" method="post">
                            <div class="form-group" >
                                <input type="hidden" name="kode_guru" value="<?php echo $kode_guru;?>">
                            <label>Kelas</label><br>         
                              <select id="kelas" name="kelas" class="form-control" autofocus>
                                <?php
                                    $sqlw = mysql_query("SELECT distinct a.id_kelas as id, b.nama_kelas as name from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode_user = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datas = mysql_fetch_array($sqlw)){
                                    echo "<option value = '".$datas['id']."'>".$datas['name']."</option>";
                                    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group" >
                            <label>Mata Pelajaran</label><br>          
                              <select id="mapel" name="mapel" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode_user = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group" >
                            <label>Kompetensi</label><br>
                                <input type="text" class="form-control" name="kompetensi" maxlenght="250" required autofocus>
                              </select>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                            </form>
                        </div> 
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
                <div class="col-md-6">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; while($row = mysql_fetch_array($sqlt)){?>
                                        <tr>
                                            <td style="text-align:center"><?php echo $row['nama_kelas']; ?></td>
                                            <td style="text-align:center"><?php echo $row['nama_pelajaran']; ?></td>
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