<?php
include "header.php";
?>
<html><head>
<title>Pemesanan</title></head><body>
<?php
if (isset($_POST['terima'])){
	include 'koneksi.php';
	$id = $_POST['terima'];
	session_start();
	unset($_SESSION['idterakhir']);
	$_SESSION['idterakhir'] = $id;
	$kuerr = "select deskripsi,tgl_pesanan from tb_pesanan where id_pesanan = $id";
	$asd = $konek->prepare($kuerr);
	$asd->execute();
	$as = $asd->fetch(PDO::FETCH_ASSOC);
	$_SESSION['deskripsi']=$as['deskripsi'];
	$_SESSION['tanggal_pesanan']=$as['tgl_pesanan'];
	header('refresh:0;url=terima-barang.php');
	}



if (isset($_POST['print'])) {
$id_dipilih = $_POST['print'];
session_start();
$_SESSION['ID_PRINT']=$id_dipilih;
	header('refresh:1;url=print.php');

}

if (isset($_POST['print2'])) {
$id_dipilih = $_POST['print2'];
session_start();
$_SESSION['ID_PRINT']=$id_dipilih;
	header('refresh:1;url=print2.php');

}
setlocale(LC_TIME, "id_ID");

if (isset($_POST['hapus'])) {
include "koneksi.php";

$id_dipilih = $_POST['hapus'];
$kry = "select * from tb_pesanan where id_pesanan=$id_dipilih";

$lol1 = $konek->prepare($kry);
$lol1->execute();
$baris = $lol1->fetch(PDO::FETCH_ASSOC);
$date = $baris['tgl_pesanan'];
$tgl = DateTime::createFromFormat('Y-m-d', $date);
$_SESSION['tgl'] = $tgl->format('d-M-Y');
$_SESSION['deskripsi'] = $baris['deskripsi'];
$tgl = $_SESSION['tgl'];
$des = $_SESSION['deskripsi'];

$kueri2 = "delete from tb_detail where id_pesanan=$id_dipilih";
$kueri = "delete from tb_pesanan where id_pesanan=$id_dipilih";
$lol = $konek->exec($kueri);
$lol2 = $konek->exec($kueri2);
?>
<div class="alert alert-success" role="alert">Pesanan <b><?php echo $des; ?></b> tanggal <b><?php echo $tgl; ?></b> telah berhasil dihapus...</div>
<?php
}

if (isset($_POST['submit'])) {
$PRINT = 0;
$STAT = 0;
    include 'koneksi.php';
    $sql="INSERT INTO tb_pesanan VALUES
	(:id,
	:deskripsi,
	:tgl,
	:print,
	:stat)";
    //('','$_POST[deskripsi]',$_POST[tgl_pesanan],0,0)";
	$statement = $konek->prepare($sql);
	$statement->bindParam(':id', $idterakhir ,PDO::PARAM_INT);       
	$statement->bindParam(':deskripsi', $_POST['deskripsi'], PDO::PARAM_STR); 
	$statement->bindParam(':tgl', $_POST['tgl_pesanan'], PDO::PARAM_STR);
	$statement->bindParam(':print', $PRINT, PDO::PARAM_BOOL); 
	$statement->bindParam(':stat', $STAT, PDO::PARAM_BOOL);   
                                      
	$statement->execute(); 
	//var_dump($statement);
	$idterakhir = $konek->lastInsertId();
	
	echo "Pemesanan ditambahkan, tunggu sebentar dan silahkan isi detail barangnya";
	session_start();
	$_SESSION["idterakhir"] = $idterakhir;
	$_SESSION["deskripsi"] = $_POST['deskripsi'];
	header('refresh:1;url=detail.php');

	$statement->closeCursor();


//	var_dump($statement);
	}
	if (isset($_POST['edit'])){
	include 'koneksi.php';
	$id = $_POST['edit'];
	session_start();
	unset($_SESSION['idterakhir']);
	$_SESSION['idterakhir'] = $_POST['edit'];
	$kuerr = "select deskripsi from tb_pesanan where id_pesanan = $id";
	$asd = $konek->prepare($kuerr);
	$asd->execute();
	$as = $asd->fetch(PDO::FETCH_ASSOC);
	$_SESSION['deskripsi']=$as['deskripsi'];
	header('refresh:0;url=detail.php');
	}
	?>
	
<div class="col-md-4"></div>
<div class="col-md-4">
<form action ="pesan.php" method="POST" class="form-horizontal">
<div class="input-group input-group-lg">
<span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Tanggal Pemesanan</span>
<input type="date" class="form-control" name="tgl_pesanan" placeholder="Tanggal Pesanan" id="tgl_pesanan" aria-describedby="sizing-addon3" required >
</div><div class="input-group input-group-lg">
<span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Deskripsi_________</span>

<input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" id="ex2" aria-describedby="sizing-addon3" required >
</div>
<button class="btn btn-primary btn-block" type="submit" value="Simpan" name="submit" label="simpan" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Simpan</button><br>
</div><div class="col-md-4"></div>


</form>
<form action="pesan.php" method="post">
<div class="container">
<table class="table">
<tr align='center' class="info"><th>No ID</th><th>Tanggal Pemesanan</th><th>Deskripsi Pemesanan</th><td align="center" colspan="2"><b>Aksi</b></td></tr>
<tbody>
<?php
include "koneksi.php";
$qry = "SELECT * FROM tb_pesanan order by tgl_pesanan desc";
$asd = $konek->prepare($qry);
$asd->execute();
while ($dataasd=$asd->fetch(PDO::FETCH_ASSOC)){

$date = $dataasd['tgl_pesanan'];
$tgl = DateTime::createFromFormat('Y-m-d', $date);
$idpesanan = $dataasd['id_pesanan'];
?>
<tr><td><?php echo $dataasd['id_pesanan']; ?></td><td><?php echo $tgl->format('d-M-Y'); ?></td><td><?php echo $dataasd['deskripsi']; ?></td>
<td align="center"><div class="btn-toolbar"><button type="submit" name="edit"  title="Edit / Ubah" class="btn btn-warning" value="<?php echo $idpesanan ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="submit" name="print"  title="Print / Cetakk" class="btn btn-success" value="<?php echo $idpesanan ?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button><button type="submit" name="hapus" title="Hapus?"  class="btn btn-danger" value="<?php echo $idpesanan ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button type="submit" name="terima" title="Terima Barang" class="btn btn-info" value="<?php echo $idpesanan ?>"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></button></td><td><button type="submit" name="print2" title="SIP LAH" class="btn btn-default" value="<?php echo $idpesanan ?>"><span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></button></div></td>

</tr>
<?php }
?>
</form>
</tbody></table></div></body>