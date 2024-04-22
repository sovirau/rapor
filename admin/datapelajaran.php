<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $cari = $_POST['cari'];
  $query = mysql_query("SELECT * from tb_pelajaran where nama_pelajaran like '%$cari%' or kelompok like '%$cari%' order by kelompok");

  if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
    $nama_pelajaran = $_POST['mapel'];
    $kkm = $_POST['kkm'];
    $kelompok = $_POST['kelompok'];

    $sqlp = mysql_query("SELECT * from tb_pelajaran where nama_pelajaran = '$nama_pelajaran'");
    $cekp = mysql_num_rows($sqlp);

    if($cekp){
        echo "<script> alert ('Data Sudah Ada!');  document.location='home.php?pages=datapelajaran'; </script>";
    }
    else {
        mysql_query("INSERT into tb_pelajaran (nama_pelajaran, kkm, kelompok) values ('$nama_pelajaran', '$kkm', '$kelompok')");
        echo "<script> document.location='home.php?pages=datapelajaran&submit=sukses'; </script>";
    }
  }

  if(isset($_GET['aksi']) && $_GET['aksi'] == 'edit'){
    $idp = $_POST['id_pelajaran'];
    $nama_pelajaran = $_POST['mapel'];
    $kkm = $_POST['kkm'];
    $kelompok = $_POST['kelompok'];

        $sqlup = mysql_query("UPDATE tb_pelajaran set nama_pelajaran = '$nama_pelajaran', kkm = '$kkm', kelompok = '$kelompok' where id_pelajaran = '$idp'");
        echo "<script> document.location='home.php?pages=datapelajaran&submit=berhasil'; </script>";
     }
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data Pelajaran</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Pelajaran
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
                    <form role="form" method="post" action="home.php?pages=datapelajaran&aksi=tambah">
                    <div class ="col-md-6 col-md-6-offset">
                            <div class="form-group" >
                                <input class="form-control" name="mapel" type="text" placeholder="Nama Pelajaran" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="kkm" type="number" placeholder="KKM" value="75" required autofocus>
                            </div>
                            <div class="form-group" >      
                              <select name="kelompok" class="form-control" data-live-search="true" autofocus>
                                  <option>Kelompok</option>
                                  <option value = "A">A</option>
                                  <option value = "B">B</option>
                                  <option value = "C">C</option>
                              </select>
                            </div><br>
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
                             Data Pelajaran
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Pelajaran</th>
                <th>KKM</th>
                <th>Kelompok</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Nama Pelajaran</th>
                <th>KKM</th>
                <th>Kelompok</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($query)){ ?>
            <tr>
                <td><?php echo $row['nama_pelajaran']; ?></td>
                <td><?php echo $row['kkm']; ?></td>
                <td><?php echo $row['kelompok']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=editpelajaran&id_pelajaran=<?php echo $row['id_pelajaran']?>"><i class = "fa fa-fw fa-edit"></i></a></td>
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