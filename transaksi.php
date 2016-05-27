<?php
require "koneksi.php";
include "header.php";

if (isset($_POST['transaksi'])){
$qtrans = "insert into tb_transaksi values(:idtrans,:idbrg,:jenis,:qty,:tgl,:ket)";
$ctrans = $konek->prepare($qtrans);
$ctrans->bindParam(':idtrans', $idtrans ,PDO::PARAM_INT); 
$ctrans->bindParam(':idbrg', $_POST['id_barang'] ,PDO::PARAM_INT); 
$ctrans->bindParam(':jenis', $_POST['jenis'] ,PDO::PARAM_INT); 
$ctrans->bindParam(':qty', $_POST['qty'] ,PDO::PARAM_INT); 
$ctrans->bindParam(':tgl', $_POST['tgl'] ,PDO::PARAM_STR); 
$ctrans->bindParam(':ket', $_POST['ket'] ,PDO::PARAM_STR); 

$hasiltrans = $ctrans->execute();
$idtrans=$konek->lastInsertId();

}

$kueribarang = "select id_barang, nama_barang, satuan, stok from tb_barang";
$konekbarang = $konek->prepare($kueribarang);
$konekbarang->execute();


$kueritrans = "select t.id_transaksi,t.tgl_transaksi,b.nama_barang,t.jenis,t.qty,b.satuan,t.keterangan from tb_transaksi t, tb_barang b where b.id_barang = t.id_barang";
$konektrans = $konek->prepare($kueritrans);
$konektrans->execute();



?>
<html><head><title>Transaksi</title>



</head>
<body>
<style>
.list {
  font-family:sans-serif;
}
td {
  padding:10px; 
  border:solid 1px #eee;
}

input {
  border:solid 1px #ccc;
  border-radius: 5px;
  padding:7px 14px;
  margin-bottom:10px
}
input:focus {
  outline:none;
  border-color:#aaa;
}
.sort {
  padding:8px 30px;
  border-radius: 6px;
  border:none;
  display:inline-block;
  color:#fff;
  text-decoration: none;
  background-color: #28a8e0;
  height:30px;
}
.sort:hover {
  text-decoration: none;
  background-color:#1b8aba;
}
.sort:focus {
  outline:none;
}
.sort:after {
  display:inline-block;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid transparent;
  content:"";
  position: relative;
  top:-10px;
  right:-5px;
}
.sort.asc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #fff;
  content:"";
  position: relative;
  top:4px;
  right:-5px;
}
.sort.desc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid #fff;
  content:"";
  position: relative;
  top:-4px;
  right:-5px;
}
</style>
 <div class="col-md-4" style="overflow: auto">
      <div class="panel panel-primary">
	  
	  <div class="panel-heading">
	  <div class="text-center"><b>Input Barang</b></div>
	  </div>
	  <div class="panel-body">
<form action="transaksi.php" method="post" class="form-horizontal">
<div class="form-group">
<label for="id_barang" class="col-sm-4 control-label">Nama Barang</label>
<div class="col-sm-8">
<SELECT class="form-control" id="id_barang" name="id_barang" required>
<?php while ($trans=$konekbarang->fetch(PDO::FETCH_ASSOC)){
?>
<option value="<?php echo $trans['id_barang']; ?>"><?php echo $trans['nama_barang']; ?></option>
<?php } ?>
</select>
</div>
</div>



<div class="form-group">
<label for="jenis" class="col-sm-4 control-label">Jenis Transaksi</label>
<div class="col-sm-8">
<SELECT class="form-control" id="jenis" name="jenis" required>

<option value="0">Masuk</option>
<option value="1">Keluar</option>

</select>
</div>
</div>


<div class="form-group">
<label for="qty" class="col-sm-4 control-label">Qty</label>
<div class="col-sm-8">
<input required placeholder="Qty" id="qty" type="text" name="qty" size="1"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="text-align:right; outline : none;" class="form-control">
</div>
</div>
<div class="form-group">
<label for="tgl" class="col-sm-4 control-label">Tanggal</label>
<div class="col-sm-8">
<input required placeholder="tgl" type="date" id="tgl" name="tgl" size="20" class="form-control">
</div>
</div>
<div class="form-group">
<label for="ket" class="col-sm-4 control-label">Keterangan</label>
<div class="col-sm-8">
<input required placeholder="Keterangan" id="ket" type="text" name="ket" class="form-control">
</div>
</div>
<div class="col-md-9"></div>
<div class="col-md-3">
<div class="form-group">
<input class="btn btn-success" type="submit" value="transaksi" name="transaksi" title="Tambah barang">


    </div></div>
	</form>
	</div></div>
	</div>

<div class="col-md-8">
 <div class="panel panel-primary">
	  
	  <div class="panel-heading">
	  <div class="text-center"><b>Data Tansaksi</b></div>
	  </div>
	  <div class="panel-body">




<div id="transaksi">
<input class="search" placeholder="Cari dan Filter" />
<button class="sort" data-sort="id">#ID</button>
<button class="sort" data-sort="nama">Nama</button>
<button class="sort" data-sort="jenis">Jenis</button>
<button class="sort" data-sort="tgl">Tanggal</button>
<button class="sort" data-sort="qty">Qty</button>
<button class="sort" data-sort="keterangan">Ket.</button>
<form action="transaksi.php" method="post" name="hapus">
<table class="table"">
<thead><tr class='info'><th>#ID</th><th>Tanggal</th><th width="100px">Nama Barang</th><th>Jenis</th><th colspan="2">Qty</th><th>Keterangan</th><th>Aksi</th></tr></th></thead> 
<tbody class="list">
<?php

$i=1;
while($trans = $konektrans->fetch(PDO::FETCH_ASSOC)) {

  	
	
	$idtrans = $trans['id_transaksi'];
	?>
	<tr><td class="id"><?php echo $idtrans; ?></td><td class="tgl"><?php echo $trans['tgl_transaksi']; ?></td><td class="nama"><?php echo $trans['nama_barang']; ?></td><td class="jenis"><?php 
	if ($trans['jenis']==0){echo "Masuk";}else if($trans['jenis']==1){echo "Keluar";}?></td><td class="qty"><?php echo $trans['qty']; ?></td><td><?php echo $trans['satuan']; ?></td><td class="keterangan"><?php echo $trans['keterangan']; ?></td>
	<td>
	<button class="btn btn-info" title="Ubah ?" type="submit" name="ubah" value="<?php echo "$idtrans"; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
	<button class="btn btn-danger" title="Hapus ?" type="submit" name="hapus" value="<?php echo "$idtrans"; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

    <?php /* <a href="detail.php?iddetail=<?php echo $iddetail; ?>"> <i class="material-icons w3-xlarge">delete</i>
	 <input type="hidden" name="hapus" value="<?php echo $row['id_detail']; ?>">
	 
	 </a>
	*/
	?>
</td>


</tr>
	<?php $i++;
}
?>
</tbody>
</table></div></form></div>
<script>
var options = {
  valueNames: [ 'id','tgl','nama','jenis','qty', 'keterangan' ]
};

var userList = new List('transaksi', options);
</script>
</div>
</div>
</body>
</html>