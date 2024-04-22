<?php
/* 
author : aldi arema
*/  
 // mesetting direktori FPDF 
// require('fpdf17/fpdf.php');
require('../fpdf/fpdf.php');
include_once '../admin/config.php';
$nama = 'fak';
$isi = 'fak';
$tgl = 'fak';
$laporan = 'fak';
$bulan = 'fak';
$tahun = 'fak';
$kategori = 'fak';

$fkodeguru = $_GET['kode_guru'];
$fmapel = $_GET['id_pelajaran'];
$fkelas = $_GET['id_kelas'];
$fbab = $_GET['id_bab'];

$data 	= mysql_query("SELECT * from tb_guru where kode_guru = '$fkodeguru' ");
$data1	= mysql_query("SELECT * from tb_pelajaran where id_pelajaran = '$fmapel' ");
$data2	= mysql_query("SELECT * from tb_kelas where id_kelas = '$fkelas' ");
$data3	= mysql_query("SELECT * from tb_bab where id_bab = '$fbab' ");
$row  = mysql_fetch_array($data);
$row1 = mysql_fetch_array($data1);
$row2 = mysql_fetch_array($data2);
$row3 = mysql_fetch_array($data3);
$id = $row['nama_guru'];
$m = $row1['nama_pelajaran'];
$k = $row2['nama_kelas'];
$ko = $row3['nama_bab'];

$sqlnilai = mysql_query("SELECT a.*, b.* from tb_nilai a 
						inner join tb_siswa b on a.nis = b.nis
						where a.id_kelas = '$fkelas' and a.id_pelajaran = '$fmapel' and a.id_bab = '$fbab'
						order by b.nama_siswa");
$kkm = mysql_query("SELECT * from tb_pelajaran where id_pelajaran = '$fmapel'");
$kkmr = mysql_fetch_array($kkm);
$merah = $kkmr['kkm'];

//Meninitial objek FPDF 
 $pdf=new FPDF(); 
 $pdf->Open(); 
  
 //Menambah Halaman 
 $pdf->AddPage(); 
  
 //Menentukan jenis huruf 
 $pdf->SetFont('Arial', 'B',11); 
  
 //mengubah mengubah warna font menjadi Merah 
 $pdf->SetTextColor(0,0,0);  
  
 // Mencetak tulisan  
 // Angka 0  menunjukan lebar space tulisan  dari kiri kekanan,jika 0 berarti lebarnya maksimum sesuai dengan lebar kertas 
 // Angka dua menunjukan tinggi tulisan  
 // Angka 0 parameter ke-4 menunjukan tanpa border 
 // Angka 0 parameter ke-5 menunjukan aris selanjutnya yang pada kasus ini kita gantikan dengan Ln() 
 $pdf->Image('smk.png',10,4,45);
 $pdf->SetFont('Arial', 'B',18);
 $pdf->Cell(70,2, '',0,0);
 $pdf->Cell(80,2, 'L A P O R A N',0,0, 'C');
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->SetFont('Arial', 'B',12);
 $pdf->Cell(70,2, '',0,0);
 $pdf->Cell(0,2, 'Pencapaian Kompetensi Peserta Didik',0,0);
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->SetFont('Arial', 'B',14);
 $pdf->Cell(83,2, '',0,0);
 $pdf->Cell(0,2, 'SMK PGRI 3 MALANG',0,0);
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->SetFont('Arial', '',9);
 $pdf->Cell(43,2, '',0,0);
 $pdf->Cell(0,2, 'Jl. Raya Tlogomas IX No. 29 - Malang Phone (0341) 554383 NSS/NDS 324056104012/4205320201',0,0);
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
  //$pdf->Line(20, 15, 190, 15);
 $pdf->SetLineWidth(1);
 $pdf->Line(10,33,200,33);
 $pdf->SetLineWidth(0);
 $pdf->Line(10,34,200,34);
 $pdf->Ln();
 $pdf->SetFont('Arial', 'B',10);
$pdf-> Cell(110,6,'Nama Guru: '.$id.'',0,0);
$pdf-> Cell(80,6,'Kelas : '.$k.'',0,1);
$pdf-> Cell(110,6,'Nama Pelajaran : '.$m.'',0,0);
$pdf-> Cell(80,6,'Nama Kompetensi : '.$ko.'',0,1);
$pdf->Ln();	
 	$pdf-> Cell(20,6,'NIS. ',1,0);
 	$pdf-> Cell(80,6,'Nama Siswa ',1,0, 'C');
 	$pdf-> Cell(30,6,'Pengetahuan ',1,0, 'C');
 	$pdf-> Cell(30,6,'Ketrampilan ',1,0, 'C');
 	$pdf-> Cell(30,6,'Sikap ',1,1, 'C');
	 	$pdf->SetFont('Arial', '',10);
	 	while ($data = mysql_fetch_assoc($sqlnilai)) {
	 		if($data['nilai_p'] <= $merah){
	 		$pdf-> Cell(20,6,$data['nis'],1,0);
		 	$pdf-> Cell(80,6,$data['nama_siswa'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(30,6,$data['nilai_p'],1,0, 'C');
	 		$pdf->SetTextColor(0,0,0);  
		 	$pdf-> Cell(30,6,$data['nilai_k'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_s'],1,1, 'C');
		 }
	 		elseif($data['nilai_k'] <= $merah){
	 		$pdf-> Cell(20,6,$data['nis'],1,0);
		 	$pdf-> Cell(80,6,$data['nama_siswa'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_p'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(30,6,$data['nilai_k'],1,0, 'C');
	 		$pdf->SetTextColor(0,0,0);  
		 	$pdf-> Cell(30,6,$data['nilai_s'],1,1, 'C');
		 }
	 		elseif($data['nilai_s'] <= $merah){
	 		$pdf-> Cell(20,6,$data['nis'],1,0);
		 	$pdf-> Cell(80,6,$data['nama_siswa'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_p'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_k'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(30,6,$data['nilai_s'],1,1, 'C');
	 		$pdf->SetTextColor(0,0,0);  
		 } else {
	 			$pdf->SetTextColor(0,0,0);
	 		$pdf-> Cell(20,6,$data['nis'],1,0);
		 	$pdf-> Cell(80,6,$data['nama_siswa'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_p'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_k'],1,0, 'C');
		 	$pdf-> Cell(30,6,$data['nilai_s'],1,1, 'C');
	 		}
 	}
 	$pdf->Ln();
 	$pdf->Ln();
date_default_timezone_set('Asia/Jakarta');
$hari = array("Minggu", "Senin", "Selas", "Rabu", "Kamis", "Jum'at", "Sabtu");
$bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$now = date("l, d F Y - H:i:s");
$pdf-> Cell(10,6,'Dicetak pada: '.$now.' ');
 $pdf->output();
?> 