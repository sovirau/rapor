<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
  $("#level").change(function(){
    var kelas = $("#level").val();
    $.ajax({
        url: "cekuser.php",
        data: "level="+level,
        cache: false,
        success: function(msg){
            $("#user").html(msg);
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

    $admin = $_SESSION['admin'];  

  $cari = $_POST['cari'];
  $query = mysql_query("SELECT a.*, b.* from tb_login a
                        inner join tb_guru b on a.kode_user = b.kode_guru
                        where a.level = 'guru'");
  $querys = mysql_query("SELECT a.*, b.* from tb_login a
                         inner join tb_siswa b on a.kode_user = b.nis 
                         where a.level = 'siswa'");

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'){
        $login = $_GET['login_id'];

        $result = mysql_query("DELETE from tb_login where login_id = '$login'");

        echo "<script language = javascript> document.location='home.php?pages=datauser&submit=hapus'; </script>";
        if($result == true){
        }
        else { echo "<script language = javascript> alert('Data Gagal Dihapus'); document.location='home.php?pages=datauser'; </script>"; 
        }
    }

    if(@$_GET['aksi'] == 'tambahguru'){
        $username = $_POST['usernameg'];
        $kode_guru = $_POST['kode_guru'];
        $pass = mysql_real_escape_string($_POST['passwordg']);

        $q = mysql_query("SELECT * from tb_login where kode_guru = '$kode_guru'");
        $cek = mysql_num_rows($q);
        if($cek){
            echo "<script language = javascript> alert ('Maaf, Data yang anda masukkan sudah ada'); document.location='home.php?pages=datauser'; </script>";
        }else{
            mysql_query("INSERT into tb_login (username, password, kode_user, level, added_by) values ('$username', '$pass', '$kode_guru', 'guru', '$admin')");
            echo "<script language = javascript> document.location='home.php?pages=datauser&submit=sukses'; </script>";
        }
  }

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'edituserguru'){
    $njurusan = $_POST['jurusan'];
    $id_jurusan = $_POST['id_jurusan'];
    $sing = $_POST['singkatan'];

    $sqlp = mysql_query("UPDATE tb_jurusan set nama_jurusan = '$njurusan', singkatan = '$sing' where id_jurusan = '$id_jurusan'");
    echo "<script> document.location='home.php?pages=datajurusan&submit=berhasil';</script>";
  }

  if(@$_GET['aksi'] == 'tambahsiswa'){
        $usernames = $_POST['usernames'];
        $nis = $_POST['nis'];
        $password = mysql_real_escape_string($_POST['passwords']);

        $q = mysql_query("SELECT * from tb_login where nis = '$nis'");
        $cek = mysql_num_rows($q);
        if($cek){
            echo "<script language = javascript> alert ('Maaf, Data yang anda masukkan sudah ada'); document.location='home.php?pages=datauser'; </script>";
        }else{
            mysql_query("INSERT into tb_login (username, password, kode_user, level, added_by) values ('$usernames', '$password', '$nis', 'siswa', '$admin')");
            echo "<script language = javascript> document.location='home.php?pages=datauser&submit=sukses'; </script>";
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
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data User
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
                
            <div class="row">
            <div class="col-md-12">
            <div class="panel with-nav-tabs panel-info">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#guru" data-toggle="tab">Guru</a></li>
                      <li><a href="#siswa" data-toggle="tab">Siswa</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                     <div class="tab-content">
                        <!-- ADMIN -->
                       
                       <!--col8-->
                       <!-- GURU -->
                       <div id="guru" class="tab-pane active">
                       <div class="row">
                       <div class="col-md-10 col-md-10-offset">
                <div class = "row">
                    <form role="form" method="post" action="home.php?pages=datauser&aksi=tambahguru">
                    <div class ="col-md-6">
                            <div class="form-group" >
                                <input class="form-control" name="usernameg" type="text" placeholder="Username" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="passwordg" type="text" placeholder="Password" required autofocus>
                            </div>
                            <input type="submit" name="submitg" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                    <div class ="col-md-6">
                            <label>User</label>
                            <div class="form-group">
                                <select class="selectpicker" name="kode_guru" data-live-search="true" title="Nothing Selected" id="user">
                                <?php
                                    $sqll = mysql_query("SELECT * from tb_guru"); 
                                    while ($datal = mysql_fetch_array($sqll)){
                                        echo "<option value = '".$datal['kode_guru']."'>".$datal['nama_guru']."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                    </div>
                    </form>    
                </div>
                       </div>

                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                            <br>
                            <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Login Guru
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama Guru</th>
                <th>Kode User</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Username</th>
                <th>Nama Guru</th>
                <th>Kode User</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($query)){ ?>
            <tr>
                <td><input type = "hidden" name = "login_idg" value = "<?php echo $row['login_id']; ?>"><?php echo $row['username']; ?></td>
                <td><?php echo $row['nama_guru']; ?></td>
                <td><?php echo $row['kode_user']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=edituserguru&login_id=<?php echo $row['login_id']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=datauser&login_id=<?php echo $row['login_id']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>
                   </div></div>
                       <!-- SISWA -->
                       <div id="siswa" class="tab-pane">
                       <div class="row">
                       <div class="col-md-10 col-md-10-offset">
                <div class = "row">
                    <form role="form" method="post" action="home.php?pages=datauser&aksi=tambahsiswa">
                    <div class ="col-md-6">
                            <div class="form-group" >
                                <input class="form-control" name="usernames" type="text" placeholder="Username" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="passwords" type="text" placeholder="Password" required autofocus>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                    <div class ="col-md-6">
                            <label>User</label>
                            <div class="form-group">
                                <select class="selectpicker" data-live-search="true" name="nis" title="Nothing Selected" id="user">
                                <?php
                                    $sqll = mysql_query("SELECT * from tb_siswa"); 
                                    while ($datal = mysql_fetch_array($sqll)){
                                        echo "<option value = '".$datal['nis']."'>".$datal['nama_siswa']."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                    </div>
                    </form>    
                </div>
                       </div>
                       
                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                            <br>
                            <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Siswa
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama Siswa</th>
                <th>Kode User</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Username</th>
                <th>Nama Siswa</th>
                <th>Kode User</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($querys)){ ?>
            <tr>
                <td><input type = "hidden" name = "login_id" value = "<?php echo $row['login_id']; ?>"><?php echo $row['username']; ?></td>
                <td><?php echo $row['nama_siswa']; ?></td>
                <td><?php echo $row['kode_user']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=editusersiswa&login_id=<?php echo $row['login_id']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=datauser&login_id=<?php echo $row['login_id']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>
                   </div></div>
                    </div>
                </div>
            </div>
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