<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $cari = $_POST['cari'];
    $query = mysql_query("select nama_guru, kode_guru from tb_guru where nama_guru like '%$cari%' order by nama_guru");

  $kode_guru = $_GET['kode_guru'];
  $sql = mysql_query("SELECT a.*, b.* from tb_guru a 
                      inner join tb_login b on a.kode_guru = b.kode_user
                      where a.kode_guru = '$kode_guru'");
  $s = mysql_query("SELECT * from tb_guru where kode_guru = '$kode_guru' ");
  $data = mysql_fetch_array($s);
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
                            <li>
                                <i class="fa fa-fw fa-archive"></i> <a href = "home.php?pages=dataguru">Master Data Guru</a>
                            </li>
                            <li class="active">
                                 Edit Data Guru
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class ="row">
                    <div class="col-md-12">
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6 col-md-6-offset">
                        <form role="form" method="post" action="home.php?pages=dataguru&aksi=edit">
                            <div class="form-group" >
                                <input class="form-control" name="nama_guru" type="text" placeholder="Nama Guru" value = "<?php echo $data['nama_guru'] ?>" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="kode_guru" type="text" placeholder="Kode Guru" value = "<?php echo $data['kode_guru'] ?>" readonly>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                        </form>
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
                <td style = "text-align:center"><a href = "home.php?pages=editguru&kode_guru=<?php echo $row['kode_guru']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=dataguru&kode_guru=<?php echo $row['kode_guru']?>&aksi=hapus"><i class = "fa fa-fw fa-trash-o"></i></a></td>
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