<head>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/insert.js"></script>
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
var htmlobjek;
$(document).ready(function(){
  $("#mapel").change(function(){
    var mapel = $("#mapel").val();
    $.ajax({
        url: "cek_kompetensi.php",
        data: "mapel="+mapel,
        cache: false,
        success: function(msg){
            $("#kompetensi").html(msg);
        }
    });
  });
});
var htmlobjek;
$(document).ready(function(){
    //ajax dropdown
    $("#kompetensi").change(function(){
        var mapel = $("#mapel").val();
        var kelas = $("#kelas").val();
        var kompetensi = $("#kompetensi").val();
        $.ajax({
            type: "GET",
            url: "nilai_view.php",
            data: "op=ambilnilai&kelas="+kelas+"&mapel="+mapel+"&kompetensi="+kompetensi,
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

$kode_guru = $_SESSION['username'];
$guru = mysql_query("SELECT a.*, b.* from tb_guru a 
                    inner join tb_login b on a.kode_guru = b.kode_user
                    where b.username = '$kode_guru'");
$gururow = mysql_fetch_array($guru);
$id = $gururow['kode_guru'];

date_default_timezone_set('Asia/Jakarta');
$now = date("l, d F Y - H:i:s");

$kelas=$_GET['id_kelas'];
$sql = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    inner join tb_guru d on a.kode_guru = d.kode_guru
                    inner join tb_login e on a.kode_guru = e.kode_user
                    where a.id_kelas='$kelas' and e.kode_user = '$id'
                    order by b.nama_kelas");
$tampil = mysql_fetch_array($sql);
$sqlt = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    where a.kode_guru = '$id'");

if (isset($_POST['submit2'])) {

$amt = $_POST['jumlah'];

    $sql = mysql_query("SELECT * from tb_nilai where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["mapel"]."'and '".$_POST["kompetensi"]."'");
    $result = mysql_num_rows($sql);

    if($result >= 1){
        $query = "UPDATE tb_nilai set "; //split the mysql_query
        for($no=1; $no<=$amt; $no++) {
        $query .= "nilai_p = '".$_POST["nilai_p$no"]."', nilai_k = '".$_POST["nilai_k$no"]."', nilai_s = '".$_POST["nilai_s$no"]."' where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["mapel"]."' and id_bab = '".$_POST["kompetensi "]."', ";
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
            $qry .= "('".$_POST["nis$no"]."', '".$_POST["mapel"]."', '".$_POST["kompetensi"]."', '".$_POST["kelas"]."', '".$_POST["nilai_p$no"]."', '".$_POST["nilai_k$no"]."', '".$_POST["nilai_s$no"]."', '$id', '$now'), "; // loop the mysql_query values to avoid more server loding time
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

    $fnis = $_POST["nis$no"];
    $fmapel = $_POST["pelajaran"];
    $fbab = $_POST["bab"];
    $fkelas = $_POST["kelas"];
    $fnilaip = $_POST["nilai_p$no"];
    $fnilaik = $_POST["nilai_k$no"];
    $fnilais = $_POST["nilai_s$no"];
    $fkodeguru = $id;
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Nilai Kompetensi</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <!--    Bordered Table  -->
                            <form id="id_form" action="?pages=nilai&aksi=1" method="post">
                            <div class="form-group form-horizontal" >
                            <label>Kelas</label><br>         
                              <select id="kelas" name="kelas" class="form-control" autofocus>
                                <?php
                                    $sqlw = mysql_query("SELECT distinct a.id_kelas, b.nama_kelas from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        where a.kode_guru = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datas = mysql_fetch_array($sqlw)){
                                        echo "<option value = '".$datas['id_kelas']."'>".$datas['nama_kelas']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal" >
                            <label>Mata Pelajaran</label><br>          
                              <select id="mapel" name="mapel" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode = '$id'
                                                        order by c.nama_pelajaran"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                    </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal" >
                            <label>Kompetensi</label><br>         
                              <select id="kompetensi" name="kompetensi" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                    </div>
                    </div>
                            <!--<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-fw fa-refresh"></i></button>-->
                            </form><br><br>
                            <div id = "nilai"></div>
                     <!--  End  Bordered Table  -->
                    <!--end div-->
                </div>
                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->