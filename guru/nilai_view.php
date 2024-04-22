<head>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/insert.js"></script>
</head>
<?php 
session_start();
if(!isset($_SESSION['username'])){
  header("location:../");
}
require_once('config.php');

$kode_guru = $_SESSION['username'];
$guru = mysql_query("SELECT a.*, b.* from tb_guru a 
                    inner join tb_login b on a.kode_guru = b.kode_user
                    where b.username = '$kode_guru'");
$gururow = mysql_fetch_array($guru);
$id = $gururow['kode_guru'];
$op = $_GET['op'];

$m = $_GET['mapel'];
$ko =$_GET['kompetensi'];
$k = $_GET['kelas'];
?>
<div class="row">
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data Kompetensi
                        </div>
                        <!-- /.panel-heading -->
                    <form id="id_form" action="?pages=nilai" method="post">
                        <div class="panel-body">
                                    <?php 
                                        if($op == "ambilnilai"){
                                            $tabel = mysql_query("SELECT
                                                                    nama_siswa, nama_kelas, nis,
                                                                    (select nilai_p from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$_GET['mapel']."' and id_bab='".$_GET['kompetensi']."') as nilai_p, 
                                                                    (select nilai_k from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$_GET['mapel']."' and id_bab='".$_GET['kompetensi']."') as nilai_k, 
                                                                    (select nilai_s from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$_GET['mapel']."' and id_bab='".$_GET['kompetensi']."') as nilai_s 
                                                                from
                                                                    tb_siswa, tb_kelas
                                                                where 
                                                                    tb_siswa.id_kelas=tb_kelas.id_kelas and
                                                                    tb_kelas.id_kelas='".$_GET['kelas']."' order by nama_siswa");
                                                                ?>
                            <div class="row">
                                <div id="result"></div>
                            </div>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <input type="hidden" name="mapel" value="<?php echo $_GET['mapel'];?>">
                                    <input type="hidden" name="kompetensi" value="<?php echo $_GET['kompetensi'];?>">
                                    <input type="hidden" name="kelas" value="<?php echo $_GET['kelas'];?>">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">No</th>
                                            <th style="text-align:center">Nama Siswa</th>
                                            <th style="text-align:center">Pengetahuan</th>
                                            <th style="text-align:center">Ketrampilan</th>
                                            <th style="text-align:center">Sikap</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                            $no = 1; while($row = mysql_fetch_array($tabel)){ ?>
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center"><?php echo $no; ?></td>
                                            <td style="text-align:center"><input type="hidden" name="nis<?php echo $no;?>" value="<?php echo $row['nis'];?>"><?php echo $row['nama_siswa']; ?></td>
                                            <td style="text-align:center">
                                                <input type="number" max="100" maxLenght="2" min="0" class="form-control" name="nilai_p<?php echo $no; ?>" value="<?php echo $row['nilai_p'];?>">
                                            </td>
                                            <td style="text-align:center"><input type="number" max="100" maxLenght="2" min="0" class="form-control" name="nilai_k<?php echo $no; ?>" value="<?php echo $row['nilai_k'];?>"></td>
                                            <td style="text-align:center"><input type="number" max="100" maxLenght="2" min="0" class="form-control" name="nilai_s<?php echo $no; ?>" value="<?php echo $row['nilai_s'];?>"></td>
                                        </tr>
                                    <?php $no++; } ?>
                                    <input type="hidden" name="jumlah" value="<?php echo $no-1;?>">
                                    </table>
                                    </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" name="submit2" class="btn btn-success"><i class="fa fa-fw fa-check"></i>&nbsp;Simpan</button>
                                </div>
                        </form>
                                <div class="col-md-6">
                                    <a target="_blank" href="../fpdf/pdfr.php?kode_guru=<?php echo $id;?>&id_pelajaran=<?php echo $m;?>&id_kelas=<?php echo $k;?>&id_bab=<?php echo $ko;?>"><button type="button" name="print" class="btn btn-success pull-right"><i class="fa fa-fw fa-print"></i>&nbsp;Cetak Nilai</button>
                                    </a>
                                </div>
                            </div> 
                                    <?php } ?>
                                    <?php 
                                    $coba = mysql_fetch_array($tabel);
                                        if($coba['nilai_s'] != '' ){ ?>
                                        <script>
                                        $("#id_form :input").prop("disabled", true);
                                        </script>
                                    <?php } 
                                    ?>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->