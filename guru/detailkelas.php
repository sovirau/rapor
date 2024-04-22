<?php
error_reporting(0);
  $host = 'localhost';
  $user ='root';
  $pass = '';
  $db = 'nilai_akademik';

  $koneksi = mysql_connect($host, $user, $pass);

  $koneksi_database = mysql_select_db($db);

$id_kelas = $_GET['id_kelas'];
$id_pelajaran=$_GET['id_pelajaran'];
$sql = mysql_query("SELECT a.*, b.* from tb_kompetensi a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    where id_pelajaran = '$id_pelajaran' and id_kelas='$id_kelas'");

$query = mysql_query("SELECT * from tb_pelajaran where id_pelajaran='$id_pelajaran'");
$dataku = mysql_fetch_array($query);

$querys = mysql_query("SELECT * from tb_kelas where id_kelas='$id_kelas'");
$datakus = mysql_fetch_array($querys);

    if(isset($_POST['id_pelajaran']) && isset($_POST['bab']) && isset($_POST['id_kelas'])){
        $nama_bab=$_POST['bab'];
        $id_pelajaran=$_POST['id_pelajaran'];
        $id_kelas=$_POST['id_kelas'];

        $add=mysql_query("SELECT * from tb_bab where nama_bab = '$nama_bab'");
        $cek=mysql_num_rows($add);

        if($cek){
            echo "<script> alert('Nama Bab Sudah Ada'); document.location='index.php?pages=details';</script>";
        } else{
            mysql_query("INSERT into tb_bab ('id_pelajaran', 'id_kelas', 'nama_bab') values ('$id_pelajaran', '$id_kelas', '$nama_bab')");
            header('location:index.php?pages=details&id_kelas=1&id_pelajaran=7&submit=sukses');
        }
    }
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Data Kompetensi</h4>

                </div>

            </div>
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
                <div class="col-md-6">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data Kompetensi
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"><?php echo $datakus['nama_kelas'];?>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Kompetensi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; while($row = mysql_fetch_array($sql)){?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama_bab']; ?></td>
                                            <td><a href = "#">Details</td>
                                        </tr>
                                    <?php $no++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
                    <!--end div-->
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Kompetensi Baru
                        </div>
                        <div class="panel-body">
                        <form role="form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                            <div class = "form-group">
                                <input type="hidden" name="id_pelajaran" value="<?php echo $dataku['id_pelajaran'];?>">
                                <input type="hidden" name="id_kelas" value="<?php echo $datakus['id_kelas'];?>">
                                <input class="form-control" name="nama_pelajaran" type="text" value="<?php echo $dataku['nama_pelajaran'];?>" readonly required autofocus>
                            </div>
                            <div class = "form-group">
                                <input class="form-control" name="bab" type="text" placeholder="Nama Bab" required autofocus>
                            </div>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->