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

$kode_guru =$_SESSION['username'];
$kodeguru = $_GET['kode_guru'];

$sql = mysql_query("SELECT * from tb_guru where kode_guru = '$kodeguru'");
$row = mysql_fetch_array($sql);

if(@$_GET['aksi'] == 'edit'){
    $kode_guru = $_POST['kode_guru'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat'];
    $tgl = $_POST['tgl'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
        $dir = 'assets/img/';
        $file = $_FILES['foto']['tmp_name'];
        $name = $_FILES['foto']['name'];

    $update = mysql_query("UPDATE tb_guru set nama_guru = '$nama', alamat = '$alamat', jenis_kelamin = '$jk', tempat = '$tempat', tgl_lahir = '$tgl', foto = '$name' where kode_guru = '$kode_guru'");

    if(move_uploaded_file($file,$dir.$name)){
        echo "<script>alert('SUKSES'); document.location='?pages=dashboard';</script>";

    } else{
        echo "<script>alert('Tidak Ada Foto'); document.location='?pages=dashboard';</script>";
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
            <form id="id_form" action="?pages=edit_profil&aksi=edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="kode_guru" value="<?php echo $row['kode_guru'];?>">
                <div class="col-md-4">
                    <img class="img-responsive img-rounded" id="preview1" src="assets/img/<?php echo $row['foto']; ?>" >
                    <br>
                    <input type="file" name="foto" class="form-control" onchange="tampilkanPreview(this,'preview1')" value="<?php echo $row['foto']; ?>"  id="foto">
                    <br>
                    <small>File jangan lebih dari 2MB</small>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href = "?pages=edit_profil&kode_guru=<?php echo $row['kode_guru']; ?>"><button type="submit" name="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i>&nbsp;Simpan Profil</button></a>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $row['nama_guru'];?>">
                    </div>
                    <div class="form-group">
                        <label>Tempat, Tanggal Lahir</label>
                        <input type="text" name="tempat" class="form-control" value="<?php echo $row['tempat'];?>"> &nbsp; <input type="date" name="tgl" class="form-control" value="<?php echo $row['tgl_lahir'];?>"> 
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <br>
                        <?php
                        $jk = $row['jenis_kelamin'];
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
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat"><?php echo $row['alamat']; ?></textarea>
                    </div>
                </div>
            </form>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->