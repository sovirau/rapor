<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<script src="js/jquery.js"></script>
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
            url: "datanilai_view.php",
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
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $cari = $_POST['cari'];
  $query = mysql_query("SELECT * from tb_jurusan");

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'){
    $id_jurusan = $_GET['id_jurusan'];
    $sqld = mysql_query("DELETE from tb_jurusan where id_jurusan = '$id_jurusan'");
    
    echo "<script> document.location='home.php?pages=datajurusan&submit=hapus';</script>";
    if ($sqld == true) {
        # code...
    echo "<script> alert('Data gagal dihapus'); document.location='home.php?pages=datajurusan';";
    }
  }

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
    $njurusan = $_POST['jurusan'];
    $sing = $_POST['singkatan'];

    $query = mysql_query("SELECT * from tb_jurusan where nama_jurusan = '$njurusan' or singkatan = '$sing'");
    $check = mysql_num_rows($query);

    if($check){
        echo "<script> alert ('Maaf, data yang anda masukkan sudah ada'); document.location='home.php?pages=datajurusan'; </script>";
    }
    else{
        mysql_query("INSERT into tb_jurusan (nama_jurusan, singkatan) values ('$njurusan', '$sing')");
        echo "<script> document.location='home.php?pages=datajurusan&submit=sukses'; </script>";
    }
  }

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'edit'){
    $njurusan = $_POST['jurusan'];
    $id_jurusan = $_POST['id_jurusan'];
    $sing = $_POST['singkatan'];

    $sqlp = mysql_query("UPDATE tb_jurusan set nama_jurusan = '$njurusan', singkatan = '$sing' where id_jurusan = '$id_jurusan'");
    echo "<script> document.location='home.php?pages=datajurusan&submit=berhasil';</script>";
  }
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Data Nilai
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Data Nilai
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class ="row">
                    <div class="col-md-12">
                        <?php 
                        if($_GET['submit']=='sukses'){
                            echo '<div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Tambah Data Sukses</div>';
                        }elseif ($_GET['submit']=='berhasil') {
                            echo '<div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Ubah Data Sukses</div>';
                        }elseif ($_GET['submit']=='hapus') {
                            echo '<div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-ok"></span> Hapus Data Sukses</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-md-4">
                    <!--    Bordered Table  -->
                            <form id="id_form" action="?pages=nilai&aksi=1" method="post">
                            <div class="form-group form-horizontal" >
                            <label>Kelas</label><br>         
                              <select id="kelas" name="kelas" class="form-control" autofocus>
                                <?php
                                    $sqlw = mysql_query("SELECT * from tb_kelas
                                                        order by nama_kelas"); 
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
                <div class="row">
                    <div id ="nilai"></div>
                </div>

    <!-- DATA TABLE SCRIPTS -->
    <script src="js/dataTables/jquery-1.11.3.min.js"></script>
    <script src="js/dataTables/jquery.dataTables.js"></script>
    <script src="js/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/dataTables/dataTables.responsive.js"></script>
    <script src="js/dataTables/jquery.dataTables.js"></script>
    <script src="js/dataTables/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#example').dataTable();
            });
        </script>   