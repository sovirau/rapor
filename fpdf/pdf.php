<?php
/* 
author : aldi arema
*/  
 // mesetting direktori FPDF 
// require('fpdf17/fpdf.php');
require('fpdf.php');
include_once '../conn/koneksi.php';
$id_lap = $_GET['id_lap'];
//$id = $_GET['id_detail'];
$sql = mysql_query("SELECT * from tb_laporan, tb_katlap where tb_laporan.id_kategori=tb_katlap.id_kategori and tb_laporan.id_laporan=$id_lap");
$data =  mysql_fetch_array($sql);
$nama = $data['judul_laporan'];
$isi = $data['isi_laporan'];
$tgl = $data['tgl_laporan'];
$laporan = $data['nama_kategori'];
$bulan = $data['bulan'];
$tahun = $data['tahun'];
$kategori = $data['id_kategori'];

$sql_pemasukan = mysql_query("SELECT * from tb_pemasukan where bulan='$bulan' and tahun='$tahun'");
$total_pemasukan = mysql_query("SELECT sum(jml_pemasukan) as jml1 from tb_pemasukan where bulan='$bulan' and tahun='$tahun'");
$total = mysql_fetch_assoc($total_pemasukan);
$sql_pengeluaran = mysql_query("SELECT * from tb_pengeluaran where bulan='$bulan' and tahun='$tahun'");
$total_pengeluaran = mysql_query("SELECT sum(jml_pengeluaran) as jml1 from tb_pengeluaran where bulan='$bulan' and tahun='$tahun'");
$total2 = mysql_fetch_assoc($total_pengeluaran);
  
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
 $pdf->Image('logo.png',10,0,45);
 $pdf->Cell(50,2, '',0,0);
 $pdf->Cell(80,2, 'Masjid An-Nur Kota Batu',0,0);
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Cell(50,2, '',0,0);
 $pdf->Cell(0,2, 'Jl. Gajah Mada, Kec. Batu, Kota Batu, Jawa Timur 65311',0,0);
 $pdf->Ln();
  //$pdf->Line(20, 15, 190, 15);
 $pdf->SetLineWidth(1);
 $pdf->Line(10,25,200,25);
 $pdf->SetLineWidth(0);
 $pdf->Line(10,26,200,26);
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 $pdf->Ln();
 //pihak 1
 $pdf->SetFont('Arial', 'B',12);
 $pdf->Cell(60,10,'Laporan '.$laporan.' '.$bulan.' '.$tahun);
 $pdf->Ln();
 $pdf->SetFont('Arial', '',11);
 $pdf->Cell(40,10,'Judul Laporan');
 $pdf-> Cell(60,10,': '.$nama,0,0); 
 $pdf->Ln();
 $pdf->Cell(40,10,'Tanggal');
 $pdf-> Cell(60,10,': '.$tgl,0,0);
 $pdf-> Ln();
 $pdf->Cell(40,10,'Isi Laporan');
 $pdf-> Cell(60,10,': ',0,0);
 $pdf->Ln();
 $pdf->MultiCell(0,5,$isi); 
 $pdf->Ln();
 $pdf->SetFont('Arial', 'B',12);
 // $pdf-> Cell(60,10,'Daftar '.$laporan.' keuangan bulan '.$bulan.' '.$tahun.' :');
 if ($kategori == 1) {
 	$pdf-> Cell(60,10,'Daftar '.$laporan.' Bulan '.$bulan.' '.$tahun.' :');
 	$pdf->Ln();
 	$pdf->SetFont('Arial', 'B',10);
 	$pdf-> Cell(10,6,'No. ',1,0);
 	$pdf-> Cell(80,6,'Kegiatan ',1,0, 'C');
 	$pdf-> Cell(50,6,'Tanggal ',1,0, 'C');
 	$pdf-> Cell(50,6,'Jumlah ',1,1, 'C');
 	if (mysql_num_rows($sql_pemasukan) == 0) {
 		$pdf-> Cell(190,6,'Data tidak ada',1,0,'C');
 	}else{
 		$e=1;
	 	$pdf->SetFont('Arial', '',10);
	 	while ($in = mysql_fetch_assoc($sql_pemasukan)) {
	 		$pdf-> Cell(10,6,$e,1,0);
		 	$pdf-> Cell(80,6,$in['kegiatan_pemasukan'],1,0);
		 	$pdf-> Cell(50,6,$in['tgl_pemasukan'],1,0, 'C');
		 	$pdf-> Cell(50,6,'Rp '.number_format($in['jml_pemasukan']),1,1, 'C');
	 	$e++;}
	 	$pdf-> Cell(140,6,'TOTAL',1,0);
	 	$pdf-> Cell(50,6,'Rp '.number_format($total['jml1']),1,1, 'C');
 	}
 	
 	$pdf->Ln();
 	$pdf->SetFont('Arial', 'B',12);
 	$pdf-> Cell(60,10,'Daftar '.$laporan.' Bulan '.$bulan.' '.$tahun.' :');
 	$pdf->Ln();
 	$pdf->SetFont('Arial', 'B',10);
 	$pdf-> Cell(10,6,'No. ',1,0);
 	$pdf-> Cell(80,6,'Kegiatan ',1,0, 'C');
 	$pdf-> Cell(50,6,'Tanggal ',1,0, 'C');
 	$pdf-> Cell(50,6,'Jumlah ',1,1, 'C');
 	if (mysql_num_rows($sql_pengeluaran) == 0) {
 		$pdf-> Cell(190,6,'Data tidak ada',1,0,'C');
 	}else{
 		$e=1;
	 	$pdf->SetFont('Arial', '',10);
	 	while ($in = mysql_fetch_assoc($sql_pengeluaran)) {
	 		$pdf-> Cell(10,6,$e,1,0);
		 	$pdf-> Cell(80,6,$in['kegiatan_pengeluaran'],1,0);
		 	$pdf-> Cell(50,6,$in['tgl_pengeluaran'],1,0, 'C');
		 	$pdf-> Cell(50,6,'Rp '.number_format($in['jml_pengeluaran']),1,1, 'C');
	 	$e++;}
	 	$pdf-> Cell(140,6,'TOTAL',1,0);
	 	$pdf-> Cell(50,6,'Rp '.number_format($total2['jml1']),1,1, 'C');
 	}
 	$pdf->Ln();
 }
 elseif ($kategori == 2) {
 	$pdf-> Cell(60,10,'Daftar '.$laporan.' Keuangan Bulan '.$bulan.' '.$tahun.' :');
 	$pdf->Ln();
 	$pdf->SetFont('Arial', 'B',10);
 	$pdf-> Cell(10,6,'No. ',1,0);
 	$pdf-> Cell(80,6,'Kegiatan ',1,0, 'C');
 	$pdf-> Cell(50,6,'Tanggal ',1,0, 'C');
 	$pdf-> Cell(50,6,'Jumlah ',1,1, 'C');
 	if (mysql_num_rows($sql_pemasukan) == 0) {
 		$pdf-> Cell(190,6,'Data tidak ada',1,0,'C');
 	}else{
 		$e=1;
	 	$pdf->SetFont('Arial', '',10);
	 	while ($in = mysql_fetch_assoc($sql_pemasukan)) {
	 		$pdf-> Cell(10,6,$e,1,0);
		 	$pdf-> Cell(80,6,$in['kegiatan_pemasukan'],1,0);
		 	$pdf-> Cell(50,6,$in['tgl_pemasukan'],1,0, 'C');
		 	$pdf-> Cell(50,6,'Rp '.number_format($in['jml_pemasukan']),1,1, 'C');
	 	$e++;}
	 	$pdf-> Cell(140,6,'TOTAL',1,0);
	 	$pdf-> Cell(50,6,'Rp '.number_format($total['jml1']),1,1, 'C');
 	}
 }
 elseif ($kategori == 3) {
 	$pdf-> Cell(60,10,'Daftar '.$laporan.' Keuangan Bulan '.$bulan.' '.$tahun.' :');
 	$pdf->Ln();
 	$pdf->SetFont('Arial', 'B',10);
 	$pdf-> Cell(10,6,'No. ',1,0);
 	$pdf-> Cell(80,6,'Kegiatan ',1,0, 'C');
 	$pdf-> Cell(50,6,'Tanggal ',1,0, 'C');
 	$pdf-> Cell(50,6,'Jumlah ',1,1, 'C');
 	if (mysql_num_rows($sql_pengeluaran) == 0) {
 		$pdf-> Cell(190,6,'Data tidak ada',1,0,'C');
 	}else{
 		$e=1;
	 	$pdf->SetFont('Arial', '',10);
	 	while ($in = mysql_fetch_assoc($sql_pengeluaran)) {
	 		$pdf-> Cell(10,6,$e,1,0);
		 	$pdf-> Cell(80,6,$in['kegiatan_pengeluaran'],1,0);
		 	$pdf-> Cell(50,6,$in['tgl_pengeluaran'],1,0, 'C');
		 	$pdf-> Cell(50,6,'Rp '.number_format($in['jml_pengeluaran']),1,1, 'C');
	 	$e++;}
	 	$pdf-> Cell(140,6,'TOTAL',1,0);
	 	$pdf-> Cell(50,6,'Rp '.number_format($total2['jml1']),1,1, 'C');
 	}
 }
 $pdf->output();
?> 