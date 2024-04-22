<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $login = $_GET['login_id'];
  $query = mysql_query("SELECT * from tb_login where login_id = '$login'");
  $data = mysql_fetch_array($query);

  $sql = mysql_query("SELECT a.*, b.* from tb_login a
                        inner join tb_guru b on a.kode_user = b.kode_guru
                        where a.level = 'guru'");

  if(@$_GET['aksi'] == 'edit'){
    $username = $_POST['username'];
    $password = mysql_real_escape_string($_POST['password']);
    $login_id = $_POST['login_id'];

    if (!empty($password)) {
        $up1 = mysql_query("UPDATE tb_login set username = '$username', password = '$password' where login_id = '$login_id'");
        echo "<script language = javascript> document.location='home.php?pages=datauser&submit=berhasil'; </script>";
    } else {
        $up2 = mysql_query("UPDATE tb_login set username = '$username' where login_id = '$login_id'");
        echo "<script language = javascript> document.location='home.php?pages=datauser&submit=berhasil'; </script>";
    }
  }
?>
<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data User</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-fw fa-archive"></i> <a href = "home.php?pages=datauser">Master Data User</a>
                            </li>
                            <li class="active">
                                 Edit Data User Guru
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
                        <form role="form" method="post" action="home.php?pages=edituserguru&aksi=edit">
                            <div class="form-group" >
                                <input type="hidden" name="login_id" value = "<?php echo $data['login_id'];?>">
                                <label>Username</label>
                                <input class="form-control" name="username" type="text" value = "<?php echo $data['username'] ?>" required>
                            </div>
                            <div class="form-group" >
                                <label>Kode User</label>
                                <input class="form-control" name="kode_user" type="text" value = "<?php echo $data['kode_user'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="text" placeholder="Password">
                                <small><font color="red">*Kosongkan jika tidak ingin mengubah password.</font></small>
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
            <?php $no = 1; while($row = mysql_fetch_array($sql)){?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['kode_user']; ?></td>
                <td style = "text-align:center"><a href = "home.php?pages=edituserguru&login_id=<?php echo $row['login_id']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=datauser&login_id=<?php echo $row['login_id']?>&aksi=hapusguru" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
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