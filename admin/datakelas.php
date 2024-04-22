<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $cari = $_POST['cari'];
  $query = mysql_query("SELECT a.id_kelas, a.nama_kelas, b.nama_jurusan from tb_kelas a
                        inner join tb_jurusan b on a.id_jurusan = b.id_jurusan
                        where a.nama_kelas like '%$cari%' or b.nama_jurusan like '%$cari%'
                        order by a.nama_kelas");

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'){
      # code...
      $id_kelas = $_GET['id_kelas'];
      $sqld = mysql_query("DELETE from tb_kelas where id_kelas = '$id_kelas'");
      echo "<script> document.location='home.php?pages=datakelas&submit=hapus'; </script>";
      if ($sqld == true){ 
      }
        else
        { 
          echo "<script> alert('Data GAGAL Dihapus!'); document.location='home.php?pages=datakelas'; </script>";
        }
      } 

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
      $tingkat = $_POST['tingkat'];
      $jurusan = $_POST['jurusan'];
      $kelas = $_POST['kelas'];

        $sql1=mysql_query("SELECT * FROM tb_jurusan WHERE singkatan='$jurusan'");
        $data1=mysql_fetch_array($sql1);
        $idjurusan=$data1['id_jurusan'];
          $nama_kelas = $tingkat."".$jurusan."".$kelas;

      $sqlt = mysql_query("SELECT * from tb_kelas where tingkat = '$tingkat' and id_jurusan = '$idjurusan' and kelas = '$kelas'");
      $cekt = mysql_num_rows($sqlt);

        if($cekt){
            echo "<script> alert('Maaf, Data Yang Anda Masukkan Sudah Ada'); document.location = 'home.php?pages=datakelas'; </script>";
        } else {
          mysql_query("INSERT into tb_kelas (nama_kelas, id_jurusan, tingkat, kelas) values ('$nama_kelas', '$idjurusan', '$tingkat', '$kelas')");
          echo "<script> document.location='home.php?pages=datakelas&submit=sukses';</script>";
        }
    }
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data Kelas</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Kelas
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
                    <form role="form" method="post" action="home.php?pages=datakelas&aksi=tambah">
                    <div class ="col-md-6 col-md-6-offset">
                            <div class="form-group" >      
                              <select name="tingkat" class="form-control" data-live-search="true" title="Tingkat" autofocus>
                                <option>Tingkat</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                              </select>
                            </div>
                            <div class="form-group" >      
                              <select id="jurusan" name="jurusan" class="selectpicker" data-live-search="true" title="Jurusan" autofocus>
                                <?php 
                                    $a = mysql_query("SELECT * from tb_jurusan order by nama_jurusan asc");
                                    while ($da = mysql_fetch_array($a)){
                                        echo "<option value = '".$da['singkatan']."'>".$da['nama_jurusan']."</option>";
                                    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group" >      
                              <select name="kelas" class="form-control" data-live-search="true" autofocus>
                                  <option>Kelas</option>
                                  <option value = "A">A</option>
                                  <option value = "B">B</option>
                                  <option value = "C">C</option>
                                  <option value = "D">D</option>
                                  <option value = "E">E</option>
                                  <option value = "F">F</option>
                                  <option value = "G">G</option>
                              </select></div>
                              <br><br>
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
                             Data Kelas
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Nama Kelas</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($query)){ ?>
            <tr>
                <td><?php echo $row['nama_kelas']; ?></td>
                <td><?php echo $row['nama_jurusan']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=datakelas&id_kelas=<?php echo $row['id_kelas']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
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