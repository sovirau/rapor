<?php
session_start();
if(!isset($_SESSION['username'])){
 header("location:../");
}
require_once('config.php');

$kode_guru =$_SESSION['username'];

$sql = mysql_query("SELECT a.*, b.* from tb_guru a 
                    inner join tb_login b on a.kode_guru = b.kode_user
                    where b.username = '$kode_guru'");
$row = mysql_fetch_array($sql);

?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Dashboard</h4>

                </div>

            </div>
            <div class="row">
                <input type="hidden" name="kode_guru" value="<?php echo $row['kode_guru'];?>">
                <div class="col-md-4">
                    <img class="img-responsive img-rounded" src="assets/img/<?php echo $row['foto']; ?>" >
                    <br>
                    <h1>&nbsp;&nbsp;<?php echo $row['nama_guru']; ?></h1><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?pages=edit_profil&kode_guru=<?php echo $row['kode_guru']; ?>"><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-fw fa-edit"></i>&nbsp;Edit Profil</button></a><br>
                </div>
                <div class="col-md-4">
                    <table class="table-responsive">
                        <tr>
                            <td width="150px">Tempat, Tanggal Lahir</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $tempat = $row['tempat'];
                            $tgl_lahir = $row['tgl_lahir']; 
                            if ($tempat == '' && $tgl_lahir == '0000-00-00'){?>
                            <td>&nbsp;-</td>
                            <?php } else {?>
                            <td><?php echo $row['tempat']; ?>, <?php echo $row['tgl_lahir']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Jenis Kelamin</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $jk = $row['jenis_kelamin'];
                            if ($jk == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['jenis_kelamin']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="80px">Alamat</td>
                            <td>:&nbsp;</td>
                            <?php 
                            $alamat = $row['alamat'];
                            if ($alamat == '' ){?>
                            <td>&nbsp;-</td>
                            <?php } else { ?>
                            <td><?php echo $row['alamat']; ?></td>
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