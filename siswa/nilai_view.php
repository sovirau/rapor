<head>
<script src="assets/js/jquery.js"></script>
</head>
<?php
session_start();
if(!isset($_SESSION['username'])){
  header("location:../");
}
require_once('config.php');

$op = $_GET['op'];
$nama_siswa = $_SESSION['username'];
$siswa = mysql_query("SELECT a.*, b.* from tb_siswa a 
                    inner join tb_login b on a.nis = b.kode_user
                    where b.username = '$nama_siswa'");
$siswarow = mysql_fetch_array($siswa);
$id = $siswarow['nis'];

$cb = mysql_query("SELECT * from tb_siswa where nis = '$id'");
$rs = mysql_fetch_array($cb);

$id_kelas = $rs['id_kelas'];

$m = $_GET['mapel'];
?>
            <div class="row">
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data Kompetensi
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                    <?php 
                                        if($op == "ambilnilai"){
                                            $tabel = mysql_query("SELECT a.*, b.*, d.* from tb_nilai a, tb_pelajaran b, tb_siswa c, tb_bab d
                                                                    where a.id_pelajaran=b.id_pelajaran
                                                                    and a.id_bab=d.id_bab
                                                                    and a.nis=c.nis 
                                                                    and a.nis = '$id' 
                                                                    and a.id_pelajaran = '".$_GET['mapel']."'
                                                                    and a.id_kelas='$id_kelas'");
                                            $t = mysql_query("SELECT * from tb_pelajaran where id_pelajaran = '".$_GET['mapel']."'");
                                            $show = mysql_fetch_array($t);
                                                                ?>
                            <div class="row">
                                <div class="col-md-4 col-md-4-offset">
                                    <input type="hidden" name="pelajaran" value="<?php echo $_GET['mapel']; ?>">
                                </div>
                            </div>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">No</th>
                                            <th style="text-align:center">Kompetensi</th>
                                            <th style="text-align:center">Pengetahuan</th>
                                            <th style="text-align:center">Ketrampilan</th>
                                            <th style="text-align:center">Sikap</th>
                                        </tr>
                                    </thead>
                                    <?php if(mysql_num_rows($tabel) == 0) { ?>
                                            <tr>
                                                <td style="text-align:center" colspan="7">Belum Ada Nilai!</td>
                                            </tr>
                                    <?php } else {
                                            $no = 1; while($row = mysql_fetch_array($tabel)){ ?>
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center"><?php echo $no; ?></td>
                                            <td style="text-align:center"><?php echo $row['nama_bab'];?></td>
                                            <td style="text-align:center"><?php echo $row['nilai_p'];?></td>
                                            <td style="text-align:center"><?php echo $row['nilai_k'];?></td>
                                            <td style="text-align:center"><?php echo $row['nilai_s'];?></td>
                                        </tr>
                                    <?php $no++; } ?>
                                    <input type="hidden" name="jumlah" value="<?php echo $no-1;?>">
                                    </table>
                                    </div><br>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <!--<a href="../fpdf/pdfs.php?nis=<?php echo $id;?>&id_pelajaran=<?php echo $m;?>"><button type="submit" name="print" class="btn btn-success pull-right"><i class="fa fa-fw fa-print"></i>&nbsp;Cetak Nilai</button></a>-->
                                    <a href="#modal" data-toggle="modal" style="text-decoration:none;"><button type="submit" name="print" class="btn btn-success pull-right"><i class="fa fa-fw fa-print"></i>&nbsp;Cetak Nilai</button></a>
                                </div>
                            </div> 
                            <div id="modal" class="modal fade" >
                                <div class="modal-dialog" >
                                    <div class="modal-content" style="margin-left:200px;width:300px;margin-top:100px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Cetak Nilai:</h4>
                                        </div>
                                        <div class="modal-body">
                                            <a href="../fpdf/pdfs.php?nis=<?php echo $id;?>" target="_blank" style="text-decoration:none;">Cetak semua nilai</a><br>
                                            <a href="../fpdf/pdfo.php?nis=<?php echo $id;?>&id_pelajaran=<?php echo $m;?>" target="_blank" style="text-decoration:none;">Cetak satu nilai</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php }
                                            }
                                            else 
                                                {
                                    ?>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">No</th>
                                            <th style="text-align:center">Kompetensi</th>
                                            <th style="text-align:center">Pengetahuan</th>
                                            <th style="text-align:center">Ketrampilan</th>
                                            <th style="text-align:center">Sikap</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                            <td style="text-align:center" colspan="7">No records found!</td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->