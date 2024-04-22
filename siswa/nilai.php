<head>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
    //ajax dropdown
    $("#mapel").change(function(){
        var mapel = $("#mapel").val();
        $.ajax({
            type: "GET",
            url: "nilai_view.php",
            data: "op=ambilnilai&mapel="+mapel,
            success: function(html){
                $("#nilai").html(html);
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
 
$nama_siswa = $_SESSION['username'];
$siswa = mysql_query("SELECT a.*, b.* from tb_siswa a 
                    inner join tb_login b on a.nis = b.kode_user
                    where b.username = '$nama_siswa'");
$siswarow = mysql_fetch_array($siswa);
$id = $siswarow['nis'];

$cb = mysql_query("SELECT * from tb_siswa where nis = '$id'");
$rs = mysql_fetch_array($cb);

$id_kelas = $rs['id_kelas'];

$mapel = $_POST['pelajaran'];
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Nilai Kompetensi</h4>

                </div>

            </div>
            <div class="row">
                    <form id="id_form" action="?std=nilai&aksi=1" method="post"> 
                    <div class="col-md-6 col-md-6-offset">
                            <div class="form-group form-horizontal" >
                            <label>Mata Pelajaran</label><br>          
                              <select id="mapel" name="mapel" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.* from tb_pelajaran a
                                                        inner join tb_produktif b on a.id_pelajaran=b.id_pelajaran
                                                        where b.id_kelas='$id_kelas'"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                    </div>
                    </div>
                            </form><br><br>
                     <!--  End  Bordered Table  -->
                    <!--end div-->
                <div id="nilai"></div>
            </div>
			</div>
    <!-- CONTENT-WRAPPER SECTION END-->