<?php
session_start();
if(!isset($_SESSION['nis'])){
  header("location:../");
}
require_once('config.php');

$nama_siswa = $_SESSION['username'];
$siswa = mysql_query("SELECT a.*, b.* from tb_siswa a 
                    inner join tb_login b on a.nis = b.kode_user
                    where b.username = '$nama_siswa'");
$siswarow = mysql_fetch_array($siswa);
$id = $siswarow['nis'];

$sql = mysql_query("SELECT a.*, b.*, c.*, d.* from tb_siswa a 
    inner join tb_guru b on a.kode_guru = b.kode_guru
    inner join tb_jurusan c on a.id_jurusan = c.id_jurusan
    inner join tb_kelas d on a.id_kelas = d.id_kelas
    where a.nis = '$id'");
$row = mysql_fetch_row($sql);

/*echo "<pre>";
print_r($row);
echo "</pre>"*/
?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Data Kompetensi</h4>

                </div>

            </div>
            <div class="row">
                <input type="hidden" name="nis" value="<?php echo $row['1'];?>">
                <div class="col-md-4">
                    <img class="img-responsive img-rounded" src="assets/img/<?php echo $row['7']; ?>" >
                    <br>
                    <h1>&nbsp;&nbsp;<?php echo $row['2']; ?></h1><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?std=edit_profil&nis=<?php echo $row['1']; ?>"><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-fw fa-edit"></i>&nbsp;Edit Profil</button></a><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?std=edit_password&nis=<?php echo $row['1']; ?>"><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-fw fa-edit"></i>&nbsp;Edit Password</button></a><br>
                </div>
                <div class="col-md-4">
                    <table class="table-responsive">
                        <tr>
                            <td width="150px">Tempat, Tanggal Lahir</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $tempat = $row['5'];
                            $tgl_lahir = $row['6']; 
                            if ($tempat == '' && $tgl_lahir == '0000-00-00'){?>
                            <td>&nbsp;-</td>
                            <?php } else {?>
                            <td><?php echo $row['5']; ?>, <?php echo $row['6']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Jenis Kelamin</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $jk = $row['4'];
                            if ($jk == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['4']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Guru Wali</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $kg = $row['14'];
                            if ($kg == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['14']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Jurusan</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $j = $row['22'];
                            if ($j == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['22']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Kelas</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $k = $row['25'];
                            if ($k == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['25']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Alamat</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $alamat = $row['3'];
                            if ($alamat == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['3']; ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->