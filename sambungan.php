<?php
setlocale(LC_ALL, 'id-ID');
date_default_timezone_set('Asia/Jakarta');

$inang = "localhost";
$pengguna = "root";
$sandi = "";
$nama_basdat = "berita";

$sambungan = mysqli_connect($inang, $pengguna, $sandi);
if (!$sambungan) {
	die("Server basis data tidak dapat disambungkan.");
}

$buka = $sambungan->select_db($nama_basdat);
if (!$buka) {
	die("Basis data tidak dapat dibuka.");
}
