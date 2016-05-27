<?php
$host = "localhost";
$db = "sip_gudang";
$login = "root";
$plogin = "";


$konek = new PDO("mysql:host=$host;dbname=$db", $login, $plogin);
$konek->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>