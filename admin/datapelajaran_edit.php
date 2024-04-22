<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $cari = $_POST['cari'];
  $query = mysql_query("SELECT * from tb_pelajaran where nama_pelajaran like '%$cari%' or kelompok like '%$cari%' order by kelompok");

  $id_pelajaran = $_GET['id_pelajaran'];
  $sql = mysql_query("SELECT * from tb_pelajaran where id_pelajaran = '$id_pelajaran'");
  $data = mysql_fetch_array($sql);
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
                    <form role="form" method="post" action="home.php?pages=datapelajaran&aksi=edit">
                    <div class ="col-md-6 col-md-6-offset">
                            <div class="form-group" >
                                <input type = "hidden" name = "id_pelajaran" value = "<?php echo $data['id_pelajaran']; ?>">
                                <input class="form-control" name="mapel" type="text" placeholder="Nama Jurusan" value="<?php echo $data['nama_pelajaran']; ?>" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="kkm" type="number" placeholder="KKM" value = "<?php echo $data['kkm']; ?>" required autofocus>
                            </div>
                            <div class="form-group" >      
                                <select name="kelompok" class="form-control" data-live-search="true" value = "<?php echo $data ['kelompok'];?>" autofocus>
                                        <?php if($data ['kelompok'] == 'A') { ;?>
                                        <option value = "A" selected>A</option>
                                        <option value = "B">B</option>
                                        <option value = "C">C</option>
                                        <?php }elseif ($data ['kelompok'] == 'B') { ?>
                                        <option value = "A">A</option>
                                        <option value = "B" selected>B</option>
                                        <option value = "C">C</option>
                                        <?php }elseif ($data ['kelompok'] == 'C') { ?>
                                        <option value = "A">A</option>
                                        <option value = "B">B</option>
                                        <option value = "C" selected>C</option>
                                        <?php } else{?>
                                        <option value = "A">A</option>
                                        <option value = "B">B</option>
                                        <option value = "C">C</option>
                                        <?php } ?>
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