<head>
         <script>
            function tampilkanPreview(gambar,idpreview){
//                membuat objek gambar
                var gb = gambar.files;
                
//                loop untuk merender gambar
                for (var i = 0; i < gb.length; i++){
//                    bikin variabel
                    var gbPreview = gb[i];
                    var imageType = /image.*/;
                    var preview=document.getElementById(idpreview);            
                    var reader = new FileReader();
                    
                    if (gbPreview.type.match(imageType)) {
//                        jika tipe data sesuai
                        preview.file = gbPreview;
                        reader.onload = (function(element) { 
                            return function(e) { 
                                element.src = e.target.result; 
                            }; 
                        })(preview);
 
    //                    membaca data URL gambar
                        reader.readAsDataURL(gbPreview);
                    }else{
//                        jika tipe data tidak sesuai
                        alert("Type file tidak sesuai. Khusus image.");
                    }
                   
                }    
            }
        </script>
        
        <script>
        var file_name = document.getElementById("foto").value;
        //file_name is your file
        </script>
</head>
<?php
session_start();
if(!isset($_SESSION['username'])){
  header("location:../");
}
require_once('config.php');


$nama_siswa = $_SESSION['username'];
$siswa = mysql_query("SELECT a.*, b.* from tb_siswa a 
                    inner join tb_login b on a.nis = b.kode_user
                    where b.username = '$nama_siswa'");
$siswarow = mysql_fetch_array($siswa);
$id = $siswarow['nis'];
$nis = $_GET['nis'];

$sql = mysql_query("SELECT a.*, b.*, c.*, d.* from tb_siswa a 
    inner join tb_guru b on a.kode_guru = b.kode_guru
    inner join tb_jurusan c on a.id_jurusan = c.id_jurusan
    inner join tb_kelas d on a.id_kelas = d.id_kelas
    where a.nis = '$nis'");
$row = mysql_fetch_row($sql);

if(@$_GET['aksi'] == 'edit'){
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat'];
    $tgl = $_POST['tgl'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
        $dir = 'assets/img/';
        $file = $_FILES['foto']['tmp_name'];
        $name = $_FILES['foto']['name'];

    $update = mysql_query("UPDATE tb_siswa set nama_siswa = '$nama', alamat = '$alamat', jenis_kelamin = '$jk', tempat = '$tempat', tgl_lahir = '$tgl', foto = '$name' where nis = '$nis'");

    if(move_uploaded_file($file,$dir.$name)){
        echo "<script>alert('SUKSES'); document.location='?std=dashboard';</script>";

    } else{
        echo "<script>alert('Tidak Ada Foto'); document.location='?std=dashboard';</script>";
    }
}
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Dashboard</h4>

                </div>

            </div>
            <div class="row">
            <form id="id_form" action="?std=edit_profil&aksi=edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="nis" value="<?php echo $row['1'];?>">
                <div class="col-md-4">
                    <img class="img-responsive img-rounded" id="preview1" src="assets/img/<?php echo $row['7']; ?>" >
                    <br>
                    <input type="file" name="foto" class="form-control" onchange="tampilkanPreview(this,'preview1')" value="<?php echo $row['7']; ?>"  id="foto">
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?pages=edit_profil&nis=<?php echo $row['1']; ?>"><button type="submit" name="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i>&nbsp;Simpan Profil</button></a>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor Induk</label>
                        <input type="text" name="nis" class="form-control" value="<?php echo $row['1'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $row['2'];?>">
                    </div>
                    <div class="form-group">
                        <label>Tempat, Tanggal Lahir</label>
                        <input type="text" name="tempat" class="form-control" value="<?php echo $row['5'];?>"> &nbsp; <input type="date" name="tgl" class="form-control" value="<?php echo $row['6'];?>"> 
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <br>
                        <?php
                        $jk = $row['4'];
                        if ($jk == 'Laki-Laki'){
                            echo '
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Laki-Laki" checked>Laki-Laki
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Perempuan">Perempuan
                            </label>';
                        } else if($jk == 'Perempuan'){
                            echo '
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Laki-Laki">Laki-Laki
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Perempuan" checked>Perempuan
                            </label>';
                        } else{
                            echo '
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Laki-Laki">Laki-Laki
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="jk" value="Perempuan">Perempuan
                            </label>';
                        }
                        ?>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label>Guru Wali</label>
                        <input type="text" name="nama_guru" class="form-control" value="<?php echo $row['14'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="<?php echo $row['22'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="<?php echo $row['25'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat"><?php echo $row['3']; ?></textarea>
                    </div>
                </div>
            </form>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->