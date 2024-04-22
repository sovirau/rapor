<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $admin = $_SESSION['admin'];

  $cari = $_POST['cari'];
    $query = mysql_query("select nama_guru, kode_guru from tb_guru where nama_guru like '%$cari%' order by nama_guru");

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'){
        $kode_guru = $_GET['kode_guru'];

        $result = mysql_query("DELETE from tb_guru where kode_guru = '$kode_guru'");
                  mysql_query("DELETE from tb_login where kode_user = '$kode_guru'");

        echo "<script language = javascript> document.location='home.php?pages=dataguru&submit=hapus'; </script>";
        if($result == true){
        }
        else { echo "<script language = javascript> alert('Data Gagal Dihapus'); document.location='home.php?pages=dataguru'; </script>"; }
        }

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
        $username = $_POST['username'];
        $nama_guru = $_POST['nama_guru'];
        $kode_guru = $_POST['kode_guru'];
        $pass = mysql_real_escape_string($_POST['password']);

        $q = mysql_query("SELECT * from tb_guru where kode_guru = '$kode_guru'");
        $cek = mysql_num_rows($q);
        if($cek){
            echo "<script language = javascript> alert ('Maaf, Data yang anda masukkan sudah ada'); document.location='home.php?pages=dataguru'; </script>";
        }else{
            mysql_query("INSERT into tb_guru (nama_guru, kode_guru, foto, password) values ('$nama_guru', '$kode_guru', 'default.png', '$pass')");
            
            echo "<script language = javascript> document.location='home.php?pages=dataguru&submit=sukses'; </script>";
        }
    }

    if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit'){
        $kode_guru = $_POST['kode_guru'];
        $nama_guru = $_POST['nama_guru'];
        $username = $_POST['username'];
        $pass = mysql_real_escape_string($_POST['password']);

        mysql_query("UPDATE tb_guru set nama_guru = '$nama_guru' where kode_guru = '$kode_guru'");
       echo "<script language = javascript> document.location='home.php?pages=dataguru&submit=berhasil'; </script>";
    } 
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data Guru</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Guru
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
                    <div class ="col-md-6 col-md-6-offset">
                        <form role="form" method="post" action="home.php?pages=dataguru&aksi=tambah">
                            <div class="form-group" >
                                <input class="form-control" name="nama_guru" type="text" placeholder="Nama Guru" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="kode_guru" type="text" placeholder="Kode Guru" required autofocus>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                            <br>
                            <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Guru
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Kode Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Kode Guru</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php $no = 1; while($row = mysql_fetch_array($query)){?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['nama_guru']; ?></td>
                <td><?php echo $row['kode_guru']; ?></td>
                <td style = "text-align:center"><a href = "home.php?pages=editguru&kode_guru=<?php echo $row['kode_guru']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=dataguru&kode_guru=<?php echo $row['kode_guru']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
            </tr>
            <?php $no++; } ?>
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