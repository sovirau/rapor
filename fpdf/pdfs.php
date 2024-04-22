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

$nis = $_GET['nis'];

$datadiri = mysql_query("SELECT distinct a.nis, a.nama_siswa, c.nama_kelas, b.semester, b.tahun_ajaran, d.nama_jurusan from tb_siswa a
						inner join tb_masterprod b on a.id_kelas = b.id_kelas
						inner join tb_kelas c on a.id_kelas = c.id_kelas
						inner join tb_jurusan d on a.id_jurusan = d.id_jurusan
						where a.nis = '$nis'");
$datarow = mysql_fetch_array($datadiri);

$datanilai = mysql_query("SELECT b.nama_pelajaran, c.nama_bab, a.nilai_p, a.nilai_k, a.nilai_k, a.nilai_s from tb_nilai a
						inner join tb_pelajaran b on a.id_pelajaran = b.id_pelajaran
						inner join tb_bab c on a.id_bab = c.id_bab
						where a.nis = '$nis'
						order by b.kelompok and b.nama_pelajaran");	

$kkm = mysql_query("SELECT * from tb_pelajaran");
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
 //$pdf->SetTextColor(194,8,8);  
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
$pdf-> Cell(110,6,'Nama Siswa : '.$datarow['nama_siswa'].'',0,0);
$pdf-> Cell(80,6,'Tahun Pelajaran : '.$datarow['tahun_ajaran'].'',0,1);
$pdf-> Cell(110,6,'Nomor Induk : '.$datarow['nis'].'',0,0);
$pdf-> Cell(80,6,'Semester : '.$datarow['semester'].' ',0,1);
$pdf-> Cell(110,6,'Kelas : '.$datarow['nama_kelas'].'',0,0);
$pdf-> Cell(80,6,'Paket Keahlian : '.$datarow['nama_jurusan'].' ',0,1);
$pdf->Ln();	
 	$pdf-> Cell(60,6,'Mata Pelajaran ',1,0, 'C');
 	$pdf-> Cell(60,6,'Nama Kompetensi ',1,0, 'C');
 	$pdf->SetFont('Arial', 'B',8);
 	$pdf-> Cell(20,6,'Pengetahuan',1,0, 'C');
 	$pdf-> Cell(20,6,'Ketrampilan',1,0, 'C');
 	$pdf-> Cell(20,6,'Sikap ',1,1, 'C');
	 	$pdf->SetFont('Arial', '',10);
	 	while ($nilai = mysql_fetch_assoc($datanilai)) {
	 		if($nilai['nilai_p'] <= $merah){
		 	$pdf-> Cell(60,6,$nilai['nama_pelajaran'],1,0, 'C');
		 	$pdf-> Cell(60,6,$nilai['nama_bab'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(20,6,$nilai['nilai_p'],1,0, 'C');
	 		$pdf->SetTextColor(0,0,0);  
		 	$pdf-> Cell(20,6,$nilai['nilai_k'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_s'],1,1, 'C');
	 		}
	 		elseif($nilai['nilai_k'] <= $merah){
		 	$pdf-> Cell(60,6,$nilai['nama_pelajaran'],1,0, 'C');
		 	$pdf-> Cell(60,6,$nilai['nama_bab'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_p'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(20,6,$nilai['nilai_k'],1,0, 'C');
	 		$pdf->SetTextColor(0,0,0);  
		 	$pdf-> Cell(20,6,$nilai['nilai_s'],1,1, 'C');  
	 		}
	 		elseif($nilai['nilai_k'] <= $merah){
		 	$pdf-> Cell(60,6,$nilai['nama_pelajaran'],1,0, 'C');
		 	$pdf-> Cell(60,6,$nilai['nama_bab'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_p'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_k'],1,0, 'C');
			$pdf->SetTextColor(194,8,8);
		 	$pdf-> Cell(20,6,$nilai['nilai_s'],1,1, 'C');
	 		$pdf->SetTextColor(0,0,0);  
	 		} else {
	 			$pdf->SetTextColor(0,0,0);
		 	$pdf-> Cell(60,6,$nilai['nama_pelajaran'],1,0, 'C');
		 	$pdf-> Cell(60,6,$nilai['nama_bab'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_p'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_k'],1,0, 'C');
		 	$pdf-> Cell(20,6,$nilai['nilai_s'],1,1, 'C');
	 		}
	 	}
 	$pdf->Ln();
 	$pdf->Ln();
date_default_timezone_set('Asia/Jakarta');
$now = date("l, d F Y - H:i:s");
$pdf-> Cell(10,6,'Dicetak pada: '.$now.' ');
 $pdf->output();
?> 