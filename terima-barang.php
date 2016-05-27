<?php

include "koneksi.php";
include "header.php";
session_start();
?>
<html>
<head>
<title>Penerimaan Barang</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php // <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css"> ?>
</head>
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td {
    border: none;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
<style type="text/css">
#wrap {
   width:100%;
   margin:0 auto;
}
#left_col {
   float:left;
   width:20%;
}
#right_col {
   width: 80%;
    overflow: auto;
    min-height:500px;
    height: 100%;
    float: right;
}

</style>

<div id="wrap">
    <div id="right_col">	 
<?php
if (isset($_POST['terimabrg'])){

$sqldetail="INSERT INTO tb_terima VALUES
	(:id_terima,
	:id_detail,
	:tgl_terima,
	:qty,
	:no_sj)";
	$tglsekarang = date("Y-m-d");
	$stmtdetail = $konek->prepare($sqldetail);
	$stmtdetail->bindParam(':id_terima', $idterima ,PDO::PARAM_INT);       
	$stmtdetail->bindParam(':id_detail', $_POST['terimabrg'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':tgl_terima', $_POST['tgl_terima'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':qty', $_POST['qty'], PDO::PARAM_INT);
	$stmtdetail->bindParam(':no_sj', $_POST['no_sj'], PDO::PARAM_STR);            
	$stmtdetail->execute(); 
	$idterima = $konek->lastInsertId();
	
	if (!$stmtdetail){
	echo "wew";
	}{
	echo "yos";
	require "koneksi.php";
	$id_pesanan = $_SESSION['idterakhir'];
    $query = "Select qty_open,qty from tb_detail where id_pesanan=$id_pesanan";
    $sql = $konek->prepare($query);
    $sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$qty_open = $row['qty_open'] - $_POST['qty'];
	$dika = "update tb_detail set qty_open = :qty_open where id_detail=:iddetail";
	$dikamaju = $konek->prepare($dika);
	$dikamaju->bindParam(':qty_open', $qty_open, PDO::PARAM_INT);
	$dikamaju->bindParam(':iddetail', $_POST['terimabrg'], PDO::PARAM_INT);
	$dikamaju->execute();
	if ($dikamaju){
	print "Berhasil diterima";
	} else{print "Gagal diterima";}
	
	}




}


	$id_pesanan = $_SESSION['idterakhir'];
    $query = "Select * from tb_detail where id_pesanan=$id_pesanan";
    $sql = $konek->prepare($query);
    $sql->execute();

?><div style="overflow-x:auto;">
<form action="terima-barang.php" method="post" name="hapus">
<table>
<thead><tr><th>No</th><th width="100px">Nama Barang</th><th>Qty Pesan</th><th>Qty Open</th><th>Satuan</th><th>Keterangan</th><th>PIC</th><th width="16px">Qty Terima</th><th>Tgl Terima</th><th>No SJ</th></tr></thead> <?php
$i=1;
while($row = $sql->fetch(PDO::FETCH_ASSOC)) {

  	
	
	$iddetail = $row['id_detail'];
	?>
	<tr><td><?php echo $i; ?></td><td><?php echo $row['nama_item']; ?></td><td class="text-right"><?php echo $row['qty'];?></td><td  class="text-right"><?php echo $row['qty_open'];?></td><td><?php echo $row['satuan']; ?></td><td><?php echo $row['keterangan']; ?></td><td><?php echo $row['pic']; ?></td>
	
	<?php
	
	if ($row['qty_open']>0){
	
	?>
	<td>
	<form method="post" action="terima-barang.php" name="terimabrg<?php echo $i; ?>">
	<input type="text" name="qty" size="3"></td><td>
	<input type="date" name="tgl_terima" size="7"></td><td>
	<input type="text" name="no_sj"></td><td>
	<button class="btn btn-success" title="Terima Barang" type="submit" name="terimabrg" value="<?php echo "$iddetail"; ?>"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span></button>
	</form>
	</td>
	<?php } else {
	?><td colspan="3">
	<input type="text" disabled value="Telah Lunas"></td>
	
	</td>
	<?php } ?>
	
	
	
	
	


</tr>
	<?php $i++;
}
?></table></form></div>
	
</div>
    </div>
    <div id="left_col">
      
<table align="center" color="silver" id="SelectNoStyle">
<?php
$qwe = $_SESSION['tanggal_pesanan'];
$tglpesanan = DateTime::createFromFormat('Y-m-d', $qwe);
?>
<tr><td>Pemesanan</td></tr><tr><td><input type="text" value="<?php echo $_SESSION["deskripsi"];  ?>" name="id_pesanan" placeholder="ID Pemesanan" id="id_pemesanan" readonly></td></tr>
<tr><td>Tanggal Pemesanan</td></tr><tr><td><input type="text" name="nama_item" placeholder="Nama Barang" id="nama_barang" readonly value="<?php echo $tglpesanan->format("d-M-Y"); ?>"></td></tr>

</table>

    </div>
</div>
