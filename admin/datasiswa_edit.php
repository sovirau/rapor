<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";
  

  $cari = $_POST['cari'];
    $query = mysql_query("SELECT a.nis, a.nama_siswa, b.nama_guru, c.nama_jurusan, d.nama_kelas from tb_siswa a
                            inner join tb_guru b on a.kode_guru = b.kode_guru
                            inner join tb_jurusan c on c.id_jurusan = a.id_jurusan
                            inner join tb_kelas d on a.id_kelas = d.id_kelas
                            where a.nama_siswa like '%$cari%' or a.nis like '%$cari%' or b.nama_guru like '%$cari%' or c.nama_jurusan like '%$cari%' or d.nama_kelas like '%$cari%' order by a.nis");

    $nis = $_GET['nis'];
    $sql = mysql_query("SELECT * from tb_siswa where nis = '$nis'");
    $data = mysql_fetch_array($sql);
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data Siswa</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Siswa
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
                    <form role="form" method="post" action="home.php?pages=datasiswa&aksi=edit">
                    <div class ="col-md-6">
                            <div class="form-group" >
                                <input class="form-control" name="nis" type="number" placeholder="NIS" value = "<?php echo $data['nis']; ?>" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="nama_siswa" type="text" placeholder="Nama Siswa" value = "<?php echo $data['nama_siswa']; ?>" required autofocus>
                            </div>
                    </div>
                    <div class ="col-md-6">
                            <div class="form-group" >             
                              <select id="guruwali" name="kode_guru" class="selectpicker" data-live-search="true" title="Guru Wali" autofocus>
                                <?php 
                                    $a = mysql_query("SELECT * from tb_guru order by nama_guru asc");
                                    while ($da = mysql_fetch_array($a)){ ?>
                                        <option value = "<?php echo $da['kode_guru']; ?>" <?php echo ($data['kode_guru'] == $da['kode_guru']) ? 'selected' : '';?> > <?php echo $da['nama_guru']; ?> </option>
                                <?php    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group" >             
                              <select id="jurusan" name="jurusan" class="selectpicker" data-live-search="true" title="Jurusan" autofocus>
                                <?php 
                                    $a = mysql_query("SELECT * from tb_jurusan order by nama_jurusan asc");
                                    while ($da = mysql_fetch_array($a)){ ?>
                                        <option value = "<?php echo $da['id_jurusan']; ?>" <?php echo ($data['id_jurusan'] == $da['id_jurusan']) ? 'selected' : '';?> > <?php echo $da['nama_jurusan']; ?></option>
                                <?php    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group" >             
                              <select id="jurusan" name="kelas" class="selectpicker" data-live-search="true" title="Kelas" autofocus>
                                <?php 
                                    $a = mysql_query("SELECT * from tb_kelas order by nama_kelas asc");
                                    while ($da = mysql_fetch_array($a)){ ?>
                                    <option value = "<?php echo $da['id_kelas']; ?> " <?php echo ($data['id_kelas'] == $da['id_kelas']) ? 'selected' : '';?> ><?php echo $da['nama_kelas']; ?></option>
                                <?php    }
                                ?>
                              </select>
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
                             Data Siswa
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Guru Wali</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Guru Wali</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($query)){ ?>
            <tr>
                <td><?php echo $row['nis']; ?></td>
                <td><?php echo $row['nama_siswa']; ?></td>
                <td><?php echo $row['nama_guru']; ?></td>
                <td><?php echo $row['nama_jurusan']; ?></td>
                <td><?php echo $row['nama_kelas']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=editsiswa&nis=<?php echo $row['nis']?>"><i class = "fa fa-fw fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "home.php?pages=datasiswa&nis=<?php echo $row['nis']?>&aksi=hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class = "fa fa-fw fa-trash-o"></i></a></td>
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