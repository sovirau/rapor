<head>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
  $("#kelas").change(function(){
    var kelas = $("#kelas").val();
    $.ajax({
        url: "cek_kompeetensi.php",
        data: "kelas="+kelas,
        cache: false,
        success: function(msg){
            $("#mapel").html(msg);
        }
    });
  });
});
var htmlobjek;
$(document).ready(function(){
  $("#mapel").change(function(){
    var mapel = $("#mapel").val();
    $.ajax({
        url: "cek_kompetensi.php",
        data: "mapel="+mapel,
        cache: false,
        success: function(msg){
            $("#kompetensi").html(msg);
        }
    });
  });
});
</script>
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

$kelas=$_GET['id_kelas'];
$sql = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                    inner join tb_kelas b on a.id_kelas = b.id_kelas
                    inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                    inner join tb_guru d on a.kode_guru = d.kode_guru
                    inner join tb_login e on a.kode_guru = e.kode_user
                    where a.id_kelas='$kelas' and e.kode_user = '$id'
                    order by b.nama_kelas");
$tampil = mysql_fetch_array($sql);
$sqlt = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                    inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
                    inner join tb_kelas c on a.id_kelas = c.id_kelas
                    where a.kode_guru = '$id'");


if(isset($_POST['submit2'])) {
    $amt = $_POST['jumlah'];

    $sql = mysql_query("SELECT * from tb_nilai where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["pelajaran"]."'and '".$_POST["bab"]."'");
    $result = mysql_num_rows($sql);

    if($result >= 1){
        $query = "UPDATE tb_nilai set "; //split the mysql_query
        for($no=1; $no<=$amt; $no++) {
        $query .= "nilai_p = '".$_POST["nilai_p$no"]."', nilai_k = '".$_POST["nilai_k$no"]."', nilai_s = '".$_POST["nilai_s$no"]."' where nis = '".$_POST["nis$no"]."' and id_pelajaran = '".$_POST["pelajaran"]."' and id_bab = '".$_POST["bab"]."', ";
        }
        $query  = substr($query, 0, strlen($query)-2);
        $update = mysql_query($query); // Execute the mysql_query
        if($update){
            echo "<script> alert('Update Data Success'); window.location='?pages=nilai';</script>";
    }
        else {
            echo "<script> alert('Update Data failed'); window.location='?pages=nilai'; </script>";
        }
    }
else{
        $qry = "INSERT INTO tb_nilai(nis, id_pelajaran, id_bab, id_kelas, nilai_p, nilai_k, nilai_s, addedby, updated) VALUES "; // Split the mysql_query
        for($no=1; $no<=$amt; $no++) {
            $qry .= "('".$_POST["nis$no"]."', '".$_POST["pelajaran"]."', '".$_POST["bab"]."', '".$_POST["id_kelas"]."', '".$_POST["nilai_p$no"]."', '".$_POST["nilai_k$no"]."', '".$_POST["nilai_s$no"]."', '$id', 'now()'), "; // loop the mysql_query values to avoid more server loding time
        }
        $qry    = substr($qry, 0, strlen($qry)-2);
        $insert = mysql_query($qry); // Execute the mysql_query
    // Redirect for each cases
    if($insert) {
            echo "<script> alert('Add Data Success'); window.location='?pages=nilai';</script>";
    }
    else {
            echo "<script> alert('Add Data failed'); window.location='?pages=nilai'; </script>";
    }
}
}

    $fnis = $_POST["nis$no"];
    $fmapel = $_POST["pelajaran"];
    $fbab = $_POST["bab"];
    $fkelas = $_POST["kelas"];
    $fnilaip = $_POST["nilai_p$no"];
    $fnilaik = $_POST["nilai_k$no"];
    $fnilais = $_POST["nilai_s$no"];
    $fkodeguru = $id;
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Nilai Kompetensi</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <!--    Bordered Table  -->
                            <form id="id_form" action="?pages=nilai&aksi=1" method="post">
                            <div class="form-group form-horizontal" >
                            <label>Kelas</label><br>         
                              <select id="kelas" name="kelas" class="form-control" autofocus>
                                <?php
                                    $sqlw = mysql_query("SELECT distinct a.id_kelas, b.nama_kelas from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        where a.kode_guru = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datas = mysql_fetch_array($sqlw)){
                                        echo "<option value = '".$datas['id_kelas']."'>".$datas['nama_kelas']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal" >
                            <label>Mata Pelajaran</label><br>          
                              <select id="mapel" name="mapel" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode = '$id'
                                                        order by c.nama_pelajaran"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                    </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal" >
                            <label>Kompetensi</label><br>         
                              <select id="kompetensi" name="kompetensi" class="form-control" autofocus>
                                <?php
                                    $sqla = mysql_query("SELECT a.*, b.*, c.*, d.kode_guru from tb_masterprod a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        inner join tb_guru d on a.kode_guru = d.kode_guru
                                                        inner join tb_login e on a.kode_guru = e.kode_user
                                                        where e.kode = '$id'
                                                        order by b.nama_kelas"); 
                                    echo "<option></option>";
                                    while ($datam = mysql_fetch_array($sqla)){
                                        echo "<option value = '".$datam['id_pelajaran']."'>".$datam['nama_pelajaran']."</option>";
                                    }
                                ?>
                              </select>
                        </div>
                    </div>
                    </div>
                            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-fw fa-refresh"></i></button>
                            </form><br><br>
                     <!--  End  Bordered Table  -->
                    <!--end div-->
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
                                        if(@$_GET['aksi'] == '1'){
                                            $kelas = $_POST['kelas'];
                                            $mapel = $_POST['mapel'];
                                            $kompetensi = $_POST['kompetensi'];
                                            $tabel = mysql_query("SELECT
                                                                    nama_siswa, nama_kelas, nis,
                                                                    (select nilai_p from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_p, 
                                                                    (select nilai_k from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_k, 
                                                                    (select nilai_s from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_s 
                                                                from
                                                                    tb_siswa, tb_kelas
                                                                where 
                                                                    tb_siswa.id_kelas=tb_kelas.id_kelas and
                                                                    tb_kelas.id_kelas='".$kelas."' order by nama_siswa");
                                            $t = mysql_query("SELECT a.*, b.*, c.* from tb_bab a
                                                        inner join tb_kelas b on a.id_kelas = b.id_kelas
                                                        inner join tb_pelajaran c on a.id_pelajaran = c.id_pelajaran
                                                        where a.id_pelajaran = '$mapel' and a.id_bab = '$kompetensi' and b.id_kelas = '$kelas'");
                                            $show = mysql_fetch_array($t);
                                                                ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="id_kelas" value="<?php echo $kelas; ?>">
                                    Kelas: <?php echo $show['nama_kelas']; ?>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="pelajaran" value="<?php echo $mapel; ?>">
                                    Mata Pelajaran: <?php echo $show['nama_pelajaran']; ?>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="bab" value="<?php echo $kompetensi; ?>">
                                    Kompetensi: <?php echo $show['nama_bab']; ?>
                                </div>
                            </div>
                            <div class="table-responsive table-bordered">
                                <table class="table">
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
                                    <a target="_blank" href="../fpdf/pdfr.php?kode_guru=<?php echo $fkodeguru;?>&id_pelajaran=<?php echo $show['id_pelajaran'];?>&id_kelas=<?php echo $show['id_kelas'];?>&id_bab=<?php echo $show['id_bab'];?>"><button type="button" name="print" class="btn btn-success pull-right"><i class="fa fa-fw fa-print"></i>&nbsp;Cetak Nilai</button>
                                    </a>
                                </div>
                        </form>
                            </div> 
                                    <?php }else { ?>
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">No</th>
                                            <th style="text-align:center">Nama Siswa</th>
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