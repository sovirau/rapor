<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
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
                            Master Data <small>Data Jurusan</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Jurusan
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
                    <form role="form" method="post" action="home.php?pages=datajurusan&aksi=tambah">
                    <div class ="col-md-6 col-md-6-offset">
                            <div class="form-group" >
                                <input class="form-control" name="jurusan" type="text" placeholder="Nama Jurusan" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="singkatan" type="text" placeholder="Singkatan" required autofocus>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                    </form>    
                </div>
                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                            <br>
                            <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Jurusan
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Nama Jurusan</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($query)){ ?>
            <tr>
                <td><input type = "hidden" name = "id_jurusan" value = "<?php echo $row['id_jurusan']; ?>"><?php echo $row['nama_jurusan']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=editjurusan&id_jurusan=<?php echo $row['id_jurusan']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=datajurusan&id_jurusan=<?php echo $row['id_jurusan']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
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