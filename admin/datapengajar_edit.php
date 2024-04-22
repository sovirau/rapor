<head>
    <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /></head>
<?php
if(!isset($_SESSION['admin'])){
  header("location:index.php?submit=login");
}
  require_once "config.php";

  $id_kelas = $_GET['id_kelas'];
  $id_pelajaran = $_GET['id_pelajaran'];
  $id_prod = $_GET['prod'];
  $sql = mysql_query("SELECT * from tb_kelas where id_kelas = '$id_kelas'");
  $data = mysql_fetch_array($sql);

  $cari = $_POST['cari'];
  $kueri = mysql_query("SELECT a.*, b.nama_kelas, c.nama_pelajaran, d.kode_guru, d.nama_guru from tb_masterprod a
                      inner join tb_kelas b on b.id_kelas = a.id_kelas 
                      inner join tb_pelajaran c on c.id_pelajaran = a.id_pelajaran
                      inner join tb_guru d on d.kode_guru = a.kode_guru
                      where b.nama_kelas like '%$cari%' or c.nama_pelajaran like '%$cari%' or d.nama_guru like '%$cari%'
                      order by id_kelas");

  $sqla = mysql_query("SELECT a.*, b.nama_kelas, c.nama_pelajaran, d.kode_guru, d.nama_guru from tb_masterprod a
                      inner join tb_kelas b on b.id_kelas = a.id_kelas 
                      inner join tb_pelajaran c on c.id_pelajaran = a.id_pelajaran
                      inner join tb_guru d on d.kode_guru = a.kode_guru
                      where a.id_prod = '$id_prod'
                      order by id_kelas");
  $cek = mysql_fetch_array($sqla);
?>

<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Master Data <small>Data Pengajar</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-archive"></i> Master Data Pengajar
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
                        }elseif ($_GET['submit']=='gagal') {
                            echo '<div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-fw fa-times"></i> Data Sudah Ada!</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class = "row">
                    <form role="form" method="post" action="home.php?pages=datapengajar&aksi=edit">
                    <div class ="col-md-6">
                            <div class="form-group" >
                                <input type = "hidden" name = "kelas" value="<?php echo $cek['id_kelas']?>" required>
                                <input class="form-control" name="nama_kelas" type="text" placeholder="Nama Kelas" value = "<?php echo $cek['nama_kelas']; ?>" readonly>
                            </div>
                            <div class="form-group" >
                                <input type = "hidden" name = "mapel" value="<?php echo $cek['id_pelajaran']?>" required>
                                <input class="form-control" name="nama_mapel" type="text" placeholder="Nama Pelajaran" value = "<?php echo $cek['nama_pelajaran']; ?>" readonly>
                            </div>
                            <div class="form-group" >             
                              <select id="pengajar" name="pengajar" class="selectpicker" data-live-search="true" title="Pengajar" autofocus>
                                <?php 
                                    $a = mysql_query("SELECT * from tb_guru order by nama_guru asc");
                                    while ($da = mysql_fetch_array($a)){ ?>
                                        <option value = "<?php echo $da['kode_guru']; ?>" <?php echo ($cek['kode_guru'] == $da['kode_guru']) ? 'selected' : '';?> ><?php echo $da['nama_guru']; ?></option>
                                <?php    }
                                ?>
                              </select>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger">
                    </div>
                    <div class="col-md-6">
                        <?php if($cek['tahun_ajaran'] == ''){ ?>
                        <div class="form-group">
                        <?php $year = date('Y');?>
                        <input type = "text" class= "form-control" name = "tahun" value = "<?php echo $year; ?>/<?php echo $year+1; ?>">
                        </div>
                        <?php } else { ?>
                        <div class="form-group">
                        <input type = "text" class= "form-control" name = "tahun" value = "<?php echo $cek['tahun_ajaran']; ?>">
                        </div>
                            <?php } if($cek['semester'] == '1'){ ?>
                        <div class="form-group">
                            <select name = "semester" class = "form-control">
                                <option>Semester</option>
                                <option value = "1" selected>Ganjil</option>
                                <option value = "2">Genap</option>
                            </select>
                        </div>
                            <?php } else if($cek['semester'] == '2'){ ?>
                        <div class="form-group">
                            <select name = "semester" class = "form-control">
                                <option>Semester</option>
                                <option value = "1">Ganjil</option>
                                <option value = "2" selected>Genap</option>
                            </select>
                        </div>
                            <?php } else{ ?>
                        <div class="form-group">
                            <select name = "semester" class = "form-control">
                                <option>Semester</option>
                                <option value = "1">Ganjil</option>
                                <option value = "2">Genap</option>
                            </select>
                        </div>
                            <?php } ?>
                            <?php if($cek['hari'] == 'Senin'){ ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin" selected>Senin</option>
                                <option value = "Selasa">Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php }elseif ($cek['hari'] == 'Selasa') { ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa" selected>Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php } elseif ($cek['hari'] == 'Rabu') { ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa" >Selasa</option>
                                <option value = "Rabu"selected>Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php } elseif ($cek['hari'] == 'Kamis') { ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa">Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis"selected>Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php } elseif ($cek['hari'] == 'Jumat') { ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa">Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat"selected>Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php } elseif ($cek['hari'] == 'Sabtu') { ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa">Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu"selected>Sabtu</option>
                            </select>
                        </div>
                        <?php } else{ ?>
                        <div class="form-group">
                            <select name = "hari" class = "form-control">
                                <option>Hari</option>
                                <option value = "Senin">Senin</option>
                                <option value = "Selasa">Selasa</option>
                                <option value = "Rabu">Rabu</option>
                                <option value = "Kamis">Kamis</option>
                                <option value = "Jumat">Jumat</option>
                                <option value = "Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <?php } ?>
                        <?php if($cek['jam'] == '1'){ ?>
                        <div class="form-group">
                            <select name = "jam" class = "form-control">
                                <option>Jam Ke -</option>
                                <option value = "1"selected>1 s/d 3</option>
                                <option value = "4">4 s/d 6</option>
                                <option value = "7">7 s/d 9</option>
                                <option value = "10">10 s/d 11</option>
                            </select>
                        </div>
                        <?php } elseif($cek['jam'] == '4'){ ?>
                        <div class="form-group">
                            <select name = "jam" class = "form-control">
                                <option>Jam Ke -</option>
                                <option value = "1">1 s/d 3</option>
                                <option value = "4"selected>4 s/d 6</option>
                                <option value = "7">7 s/d 9</option>
                                <option value = "10">10 s/d 11</option>
                            </select>
                        </div>
                        <?php } elseif($cek['jam'] == '7'){ ?>
                        <div class="form-group">
                            <select name = "jam" class = "form-control">
                                <option>Jam Ke -</option>
                                <option value = "1">1 s/d 3</option>
                                <option value = "4">4 s/d 6</option>
                                <option value = "7"selected>7 s/d 9</option>
                                <option value = "10">10 s/d 11</option>
                            </select>
                        </div>
                        <?php } elseif($cek['jam'] == '10'){ ?>
                        <div class="form-group">
                            <select name = "jam" class = "form-control">
                                <option>Jam Ke -</option>
                                <option value = "1">1 s/d 3</option>
                                <option value = "4">4 s/d 6</option>
                                <option value = "7">7 s/d 9</option>
                                <option value = "10"selected>10 s/d 11</option>
                            </select>
                        </div>
                        <?php } else{ ?>
                        <div class="form-group">
                            <select name = "jam" class = "form-control">
                                <option>Jam Ke -</option>
                                <option value = "1">1 s/d 3</option>
                                <option value = "4">4 s/d 6</option>
                                <option value = "7">7 s/d 9</option>
                                <option value = "10">10 s/d 11</option>
                            </select>
                        </div>
                        <?php } ?>
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
                             Data Pengajar
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Nama Pengajar</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Semester</th>
                <th>Tahun Ajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Nama Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Nama Pengajar</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Semester</th>
                <th>Tahun Ajaran</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    
        <tbody>
            <?php while($row = mysql_fetch_array($kueri)){ ?>
            <tr>
                <td><input type = "hidden" name = "id_kelas" value = "<?php echo $row['id_kelas']; ?>"><?php echo $row['nama_kelas']; ?></td>
                <td><input type = "hidden" name = "id_pelajaran" value = "<?php echo $row['id_pelajaran']; ?>"><?php echo $row['nama_pelajaran']; ?></td>
                <td><input type = "hidden" name = "kode_guru" value = "<?php echo $row['kode_guru']; ?>"><?php echo $row['nama_guru']; ?></td>
                <td><?php echo $row['hari']; ?></td>
                <td><?php echo $row['jam']; ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td><?php echo $row['tahun_ajaran']; ?></td>
                <td style ="text-align:center"><a href = "home.php?pages=editpengajar&id_kelas=<?php echo $row['id_kelas']?>&id_pelajaran=<?php echo $row['id_pelajaran']?>"><i class = "fa fa-fw fa-edit"></i></a></td>
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