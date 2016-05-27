<?php

include "koneksi.php";
include "header.php";
session_start();
?>
<html>
<head>
<title>Detail Pemesanan</title>
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
   width:50%;
}
#right_col {
   width: 50%;
    overflow: auto;
    min-height:500px;
    height: 100%;
    float: right;
}
select, option { font-family: Consolas,  monospace;  }
</style>

<div id="wrap">
    <div id="right_col">
     
	 
	 
	 
	 
	
                
            
	 
<?php

if (isset($_POST['hapus'])){
include "koneksi.php";

$id_detail_dipilih = $_POST['hapus'];
$kry = "select b.nama_barang, d.qty, b.satuan from tb_detail d, tb_barang b where id_detail=$id_detail_dipilih and b.id_barang=d.id_barang";
$lol1 = $konek->prepare($kry);
$lol1->execute();
$baris = $lol1->fetch(PDO::FETCH_ASSOC);
$_SESSION['nama'] = $baris['nama_barang'];
$_SESSION['kuantiti'] = $baris['qty'];
$_SESSION['satuan'] = $baris['satuan'];
$nama = $_SESSION['nama'];
$kuantiti = $_SESSION['kuantiti'];
$stn = $_SESSION['satuan'];


$kueri = "delete from tb_detail where id_detail=$id_detail_dipilih";
$lol = $konek->exec($kueri);
?>
<div class="alert alert-success" role="alert">Item <b><?php echo $nama.", ".$kuantiti . " " . $stn; ?></b>  telah berhasil dihapus...</div>
<?php

} else if (isset($_POST['tambah']) ){

//TAMBAH ITEM
$sqldetail="INSERT INTO tb_detail VALUES
	(:id,
	:id_pesanan,
	:id_barang,
	:qty,
	:keterangan,
	:pic,
	:tgl_input,
	:qty_open)";
	$tglsekarang = date("Y-m-d");
	$stmtdetail = $konek->prepare($sqldetail);
	$stmtdetail->bindParam(':id', $iddetail ,PDO::PARAM_INT);       
	$stmtdetail->bindParam(':id_pesanan', /*$_POST['id_pesanan']*/$_SESSION["idterakhir"], PDO::PARAM_STR);
	$stmtdetail->bindParam(':id_barang', $_POST['id_barang'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':qty', $_POST['qty'], PDO::PARAM_INT);
	$stmtdetail->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':pic', $_POST['pic'], PDO::PARAM_STR);  
	$stmtdetail->bindParam(':tgl_input', $tglsekarang, PDO::PARAM_STR);  
	$stmtdetail->bindParam(':qty_open', $_POST['qty'], PDO::PARAM_STR);            
	$stmtdetail->execute(); 
	$iddetail = $konek->lastInsertId();
	$stmtdetail->closeCursor();

	


}


	$id_pesanan = $_SESSION['idterakhir'];
    $query = "Select b.nama_barang, d.qty, b.satuan, d.keterangan, d.pic, d.id_detail from tb_detail d, tb_barang b where d.id_pesanan=$id_pesanan and b.id_barang = d.id_barang";
    $sql = $konek->prepare($query);
    $sql->execute();

?><div style="overflow-x:auto;">
<form action="detail.php" method="post" name="hapus">
<table>
<thead><tr class='info'><th>ID</th><th width="100px">Nama Barang</th><th>Qty</th><th>Satuan</th><th>Keterangan</th><th>PIC</th><th>Aksi</th></tr></th></thead> <?php
$i=1;
while($row = $sql->fetch(PDO::FETCH_ASSOC)) {

  	
	
	$iddetail = $row['id_detail'];
	?>
	<tr><td><?php echo $i; ?></td><td><?php echo $row['nama_barang']; ?></td><td><?php echo $row['qty'];?></td><td><?php echo $row['satuan']; ?></td><td><?php echo $row['keterangan']; ?></td><td><?php echo $row['pic']; ?></td>
	<td>
	<button class="btn btn-danger" title="Hapus ?" type="submit" name="hapus" value="<?php echo "$iddetail"; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
	
    <?php /* <a href="detail.php?iddetail=<?php echo $iddetail; ?>"> <i class="material-icons w3-xlarge">delete</i>
	 <input type="hidden" name="hapus" value="<?php echo $row['id_detail']; ?>">
	 
	 </a>
	*/
	?>
</td>


</tr>
	<?php $i++;
}
?></table></form></div>
	<?php
	
	
	

	//header('refresh:3;url=detail.php');
	


?>
</div>
    </div>
    <div id="left_col">
      
<table align="center" color="silver" id="SelectNoStyle">
<form action="detail.php" method="POST" class="pure-form"> 
<tr><td>ID Pemesanan</td><td>:</td><td><input type="text" value="<?php echo $_SESSION["deskripsi"];?>" name="id_pesanan" placeholder="ID Pemesanan" id="id_pemesanan" readonly><?php echo $_SESSION["idterakhir"];  ?> </td></tr>
<tr><td>Nama Barang</td><td>:</td><td><select name="id_barang">
<?php
include "koneksi.php";
$qry = "select id_barang, nama_barang, satuan from tb_barang order by nama_barang asc";
$pdo = $konek->prepare($qry);
$pdo->execute();
while($brg = $pdo->fetch(PDO::FETCH_ASSOC)){

?>

<option value='<?php echo $brg['id_barang']; ?>'> <?php echo $brg['nama_barang']."      @<div class='text-right'>". $brg['satuan']. "</div>"; ?> </option>
<?php }
?>


</td></tr>
<tr><td>Qty</td><td>:</td><td><input type="number" name="qty" placeholder="Quantity" id="qty" required ></td></tr>

<tr><td>Keterangan</td><td>:</td><td><input type="text" name="keterangan" placeholder="Keterangan" id="Keterangan"></td></tr>
<tr><td>PIC</td><td>:</td><td><input type="text" name="pic" placeholder="PIC" id="PIC"></td></tr>

<tr><td><input type="submit" value="Simpan" name="simpan" title="Simpan dan print"></td><td></td><td><input type="submit" value="Tambah" name="tambah" title="Tambah barang"></tr>
</form>
</table>

    </div>
</div>
