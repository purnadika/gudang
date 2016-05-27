<?php
include "koneksi.php";
$ss = "select * from tb_detail where id_detail = $iddetail";
$zz = $konek->prepare($ss);
$zz->execute();
while($baris = $zz->fetch(PDO::FETCH_ASSOC)) {
session_start();
$_SESSION['nama_item'] = $baris['nama_item'];
$_SESSION['Qty'] = $baris['qty']." ".$baris['satuan'];
}
$zz->closeCursor();

echo "berhasil dihapus";

var_dump($zz);
