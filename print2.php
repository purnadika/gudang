<?php
require '/tcpdf/tcpdf.php';
include 'koneksi.php';
session_start();
setlocale(LC_TIME, "id_ID");
$id_dipilih = $_SESSION['ID_PRINT'];
//$query = "SELECT p.*, d.* FROM tb_pesanan AS p JOIN tb_detail AS d ON p.id_pesanan = d.id_pesanan WHERE p.id_pesanan = '$id_dipilih'";
$query = "select * from tb_pesanan where id_pesanan = $id_dipilih";
$eksekusi = $konek->prepare($query);
$eksekusi->execute();
$data = $eksekusi->fetch(PDO::FETCH_ASSOC);
$des = $data['deskripsi'];
$tgl = $data['tgl_pesanan'];

//--------------------------------------------------------------------------------
$query = "select * from tb_detail where id_pesanan = $id_dipilih";
$eksekusi = $konek->prepare($query);
$eksekusi->execute();



$textColour = array( 0, 0, 0 );

$PEMKOT = "PT SARANA INTI PRESISI";
$ALAMAT = 'Jl.Raya Bandung-Garut KM24,5 Komp. Industri Dwipapuri Abadi C22 No15 Sumedang';
$SURAT = 'PERMINTAAN BARANG';

$logoFile = "css/logo.jpg";

$pdf = new TCPDF( 'P', 'mm', 'A4');
$pdf->SetPrintHeader(false);
$pdf->AddPage();
$pdf->SetMargins(15, 5);
$pdf->SetPrintHeader(false);

$pdf->Image($logoFile, '15', '11', '20');
$pdf->SetFont( 'Times', 'B', 25 );
$pdf->Cell( 210, 13, $PEMKOT, 0, 0, 'C' );
$pdf->SetFont( 'Times', '', 12 ); //MME
$pdf->Ln();
$pdf->Cell( 200, 6, $ALAMAT, 0, 0, 'C' );
$pdf->Line(20, 31, 210-20, 31); // 20mm from each edge
$pdf->Line(20, 31.25, 210-20, 31.25);
$pdf->Line(22, 32, 210-22, 32);
$pdf->SetFont( 'Times', 'B', 12 ); //MME
$pdf->Ln(15);
$pdf->Cell( 0, 0, "FORM PERMINTAAN BARANG", 0, 0, 'C' );
$pdf->SetFont( 'Times', 'u', 12 ); //MME
$tgl1=DateTime::createFromFormat('Y-m-d', $tgl);
$nomor = $tgl1->format('Y')."/SIP/P/".$tgl1->format('m').$id_dipilih;
$pdf->Ln(5);

$pdf->Cell( 0, 0, "$nomor", 0, 0, 'C' );
$tanggal = $tgl1->format('d-M-Y');
$pdf->SetFont( 'Times', '', 12 ); //MME

$tabelpesanan = <<<EOD
<table><tr><td width="80px">Deskripsi</td><td width="180px">: $des</td><td width="30px"></td><td width="100px"></td></tr>
<tr><td>Tanggal</td><td>: $tanggal</td><td></td></tr></table>
EOD;
$pdf->Ln(10);
$pdf->writeHTML($tabelpesanan);
$pdf->setCellPadding('10');
$TABEL = <<< EOD

<table border="1" cellspacing="0" cellpadding="2">
<tr align="center"><td width="20px" border="1">No</td><td width="250px" border="1">Nama Item</td><td width="25px">Qty</td>
<td width="50px" border="1">Satuan</td><td width="160px" border="1">Keterangan</td></tr>

EOD;

$i = 1;
while($data = $eksekusi->fetch(PDO::FETCH_ASSOC)){
$nama = $data['nama_item'];
$qty = $data['qty'];
$satuan = $data['satuan'];
$ket = $data['keterangan'];
$pic = $data['pic'];
$TABEL  .= <<<EOD
<tr><td align="center" border="1">$i.</td><td border="1">$nama</td><td align="right">$qty</td><td> $satuan</td><td>$ket</td></tr>

EOD;
$i++;
}
$TABEL  .= <<<EOD
</table>

EOD;

$pdf->Ln(5);
 $pdf->writeHTML($TABEL);
 
 
 $foot = <<<EOD
<table><tr align="center"><td width="33%">Pemohon</td><td width="33%">Disetujui</td><td width="33%">Mengetahui</td></tr>
<tr height="50px"><td></td><td></td><td></td></tr><tr height="50px"><td></td><td></td><td></td></tr>
<tr height="50px"><td></td><td></td><td></td></tr><tr height="50px"><td></td><td></td><td></td></tr>
<tr align="center"> <td>(____________________)</td><td>(____________________)</td><td>(____________________)</td></tr></table>
 
EOD;

$pdf->Ln(15);
  $pdf->Image('tpy.png', 80, 158, 50, 45, 'PNG', '', '', true, 150, '', false, false, 0, true, false, true);
  $pdf->writeHTML($foot);
  
  $pdf->SetAlpha(100);

 // $pdf->Image("tpy.png", '100', '100', '50');
  
$pdf->Output('print.pdf', 'I');
include "header.php";
 ?>
 
 <html>
 <head> 
 <style type="text/css">
 .no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(Preloader_3.gif) center no-repeat #fff;
}
 </style><script>
 $(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
	</script>
	
 </head>
 <body>
 <div class="se-pre-con"></div>
 

 </body>
</html>

