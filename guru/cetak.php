<!-- http://phpbego.wordpress.com -->
<?php 
/*session_start();																																								
$strhtml = "<div class='tengah'><h2>DAFTAR MAHASISWA</h2></div>";
if(!isset($_SESSION['kodeguru'])){
  header("location:../");
}
require_once('config.php');
$kelas = $_GET['id_kelas'];
$mapel = $_GET['mapel'];
$kompetensi = $_GET['kompetensi'];
$sql = mysql_query("SELECT
                    nama_siswa, nama_kelas, nis,
                    (select nilai_p from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_p, 
                    (select nilai_k from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_k, 
                    (select nilai_s from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_s 
                        from
                    tb_siswa, tb_kelas
                        where 
                    tb_siswa.id_kelas=tb_kelas.id_kelas and
                    tb_kelas.id_kelas='".$kelas."' order by nama_siswa");

$strhtml .= ("<table>");
	$strhtml .= "<tr>";
		$strhtml .= "<th>ID</th>";
		$strhtml .= "<th>NIM</th>";
		$strhtml .= "<th>NAMA</th>";
		$strhtml .= "<th>JURUSAN</th>";
	$strhtml .= "</tr>";
	 while ($data = mysqli_fetch_array($sql)) {
	$strhtml .= "<tr>";
		$strhtml .= "<td>".$data['id']."</td>";
		$strhtml .= "<td>$data[nim]</td>";
		$strhtml .= "<td>$data[nama]</td>";
		$strhtml .= "<td>$data[jurusan]</td>";
	$strhtml .= "</tr>";
	} 
$strhtml .= "</table>";
$now = date("F j, Y, g:i a");
$strhtml .= "<p>Dicetak Pada : $now <p>";

// Panggil mPdf
include("../mpdf/mpdf.php");

// A4 maksudnya ukuran kertas
$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
$stylesheet = file_get_contents('../mdpf/css/style.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($strhtml);
$mpdf->Output();
*/?>	


<?php
 // Define relative path from this script to mPDF
 $nama_dokumen='PDF With MPDF'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../MPDF/');
include(_MPDF_PATH . "mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document

//Beginning Buffer to save PHP variables and HTML tags
ob_start(); 

//koneksi
include('config.php');
?>
<?php

$kelas = $_GET['id_kelas'];
$mapel = $_GET['mapel'];
$kompetensi = $_GET['kompetensi'];

$sql = mysql_query("SELECT
                    nama_siswa, nama_kelas, nis,
                    (select nilai_p from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_p, 
                    (select nilai_k from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_k, 
                    (select nilai_s from tb_nilai where tb_nilai.nis=tb_siswa.nis and tb_nilai.id_kelas=tb_kelas.id_kelas and id_pelajaran='".$mapel."' and id_bab='".$kompetensi."') as nilai_s 
                        from
                    tb_siswa, tb_kelas
                        where 
                    tb_siswa.id_kelas=tb_kelas.id_kelas and
                    tb_kelas.id_kelas='".$kelas."' order by nama_siswa");
$row = mysql_fetch_array($sql);
?>
<table>
	<tr>Kelas: <?php echo $kelas; ?></tr>
	<tr>Mata Pelajaran: <?php echo $mapel; ?></tr>
	<tr>Kompetensi: <?php echo $kompetensi; ?></tr>
	</table>

<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>