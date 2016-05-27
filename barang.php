<?php

include "koneksi.php";
include "header.php";
session_start();


?>
<html>
<head>
<title>Master Barang</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php // <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css"> ?>
</head>


<style type="text/css">

select, option { font-family: Consolas,  monospace;  }



</style>

 <div class="col-md-4" style="overflow: auto">
      <div class="panel panel-primary">
	  
	  <div class="panel-heading">
	  <div class="text-center"><b>Input Barang</b></div>
	  </div>
	  <div class="panel-body">
<form action="barang.php" method="post" class="form-horizontal">
<div class="form-group">
<label for="nama_barang" class="col-sm-4 control-label">Nama Barang</label>
<div class="col-sm-8">
<input required placeholder="Nama Barang" type="text" id="nama_barang" name="nama_barang" autofocus size="20" class="form-control">
</div>
</div>
<div class="form-group">
<label for="stok" class="col-sm-4 control-label">Stok</label>
<div class="col-sm-8">
<input required placeholder="Stok" id="stok" type="text" name="stok" size="1"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align:right; outline : none;" class="form-control">
</div>
</div>
<div class="form-group">
<label for="satuan" class="col-sm-4 control-label">Satuan</label>
<div class="col-sm-8">
<input required placeholder="Satuan" type="text" id="satuan" name="satuan" autofocus size="20" class="form-control">
</div>
</div>
<div class="form-group">
<label for="ket" class="col-sm-4 control-label">Keterangan</label>
<div class="col-sm-8">
<input required placeholder="Keterangan" id="ket" type="text" name="keterangan" class="form-control">
</div>
</div>
<div class="col-md-9"></div>
<div class="col-md-3">
<div class="form-group">
<input class="btn btn-success" type="submit" value="Tambah" name="tambah" title="Tambah barang">


    </div></div>
	</form>
	</div></div>
	</div>
   <div class="col-md-8" id="barang">
     <!--  style="height:100%; overflow: scroll" -->
	 <div class="panel panel-primary">
	  
	  <div class="panel-heading">
	  <div class="text-center"><b>Data Barang</b></div>
	  </div>
	  <div class="panel-body" style="height:89%; overflow: scroll;">
	 
	 
<?php

if (isset($_POST['hapus'])){
include "koneksi.php";

$id_barang_dipilih = $_POST['hapus'];
$kry = "select * from tb_barang where id_barang= $id_barang_dipilih order by id_barang asc";
$lol1 = $konek->prepare($kry);
$lol1->execute();
$baris = $lol1->fetch(PDO::FETCH_ASSOC);
$_SESSION['nama'] = $baris['nama_barang'];
$_SESSION['kuantiti'] = $baris['stok'];
$_SESSION['satuan'] = $baris['satuan'];
$nama = $_SESSION['nama'];
$kuantiti = $_SESSION['kuantiti'];
$stn = $_SESSION['satuan'];


$kueri = "delete from tb_barang where id_barang=$id_barang_dipilih";
$lol = $konek->exec($kueri);
?>
<div class="alert alert-success" role="alert">Item <b><?php echo $nama.", ".$kuantiti . " " . $stn; ?></b>  telah berhasil dihapus dari gudang</div>
<?php

} else if (isset($_POST['tambah']) ){
/*
		$new_file_name = strtolower($_FILES['gambar']['tmp_name']); //rename file
		move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/'.$new_file_name);
		$target_file = 'uploads/'.$new_file_name;
		
		*/
		
	
//TAMBAH ITEM
	$sqlbarang="INSERT INTO tb_barang VALUES
	(:id_barang,
	:nama_barang,
	:stok,
	:satuan,
	:keterangan,
	:gambar)";
	$tglsekarang = date("Y-m-d");
	$idbarang = $konek->lastInsertId();
	$stmtdetail = $konek->prepare($sqlbarang);
	$idbarang = $konek->lastInsertId();
	$stmtdetail->bindParam(':id_barang', $idbarang ,PDO::PARAM_INT);       
	$stmtdetail->bindParam(':nama_barang', $_POST['nama_barang'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':stok', $_POST['stok'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':satuan', $_POST['satuan'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':gambar', $target_file, PDO::PARAM_STR);              

	$idbarang = $konek->lastInsertId();
	$stmtdetail->execute();
	$idbarang = $konek->lastInsertId();
	
	
	$stmtdetail->closeCursor();

}else if (isset($_POST['ubah']) ){
$sqlbarang="update tb_barang set nama_barang =:namabarang, stok=:stok, satuan=:satuan, keterangan=:keterangan where id_barang = :idbarang";
$idbarang = $_POST['ubah'];
	$stmtdetail = $konek->prepare($sqlbarang);
      
	$stmtdetail->bindParam(':namabarang', $_POST['nama_barang'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':stok', $_POST['stok'], PDO::PARAM_INT);
	$stmtdetail->bindParam(':satuan', $_POST['satuan'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
	$stmtdetail->bindParam(':idbarang', $idbarang ,PDO::PARAM_INT); 
	$stmtdetail->execute();
	$stmtdetail->closeCursor();


}
$sor = "asc";
if (isset($_GET['namabrg'])){
$asd = "nama_barang";


}
    $query = "select * from tb_barang order by id_barang desc";
	$sql = $konek->prepare($query);
    $sql->execute();

?><!-- Single button -->

<div class="btn-group" ><div class="text-center">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Urutkan <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Nama Barang</a></li>
    <li><a href="#">Stok</a></li>
    <li><a href="#">Satuan</a></li>
	<li><a href="#">Keterangan</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">ID Barang</a></li>
  </ul></div>
</div>
<form action="barang.php" method="post" name="hapus">
<table class="table">
<thead><tr class='info'><th>ID</th><th width="100px">Nama Barang</th><th>Stok</th><th>Satuan</th><th>Keterangan</th><th>Aksi</th></tr></th></thead> 

<?php
$i=1;
while($row = $sql->fetch(PDO::FETCH_ASSOC)) {

  	
	
	$idbarang = $row['id_barang'];
	?>
	<form method="POST" action="barang.php">
	<tr><td><?php echo $i; ?></td><td contenteditable="true"><?php echo $row['nama_barang']; ?></td><td contenteditable="true"><div class="text-right"><?php echo $row['stok'];?></div></td><td contenteditable="true"><<?php echo $row['satuan']; ?></td><td contenteditable="true"><?php echo $row['keterangan']; ?></td>
	<td>
	<button class="btn btn-info" title="Ubah ?" type="submit" name="ubah" value="<?php echo "$idbarang"; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
	<button class="btn btn-danger" title="Hapus ?" type="submit" name="hapus" value="<?php echo "$idbarang"; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
	</form>
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

    

