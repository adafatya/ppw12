<?php
require("sambungan.php");

if (!isset($_GET["id"])) {
	header("Location: index.php");
	die;
}

$pemberitahuan = "";

$kueri = $sambungan->prepare("DELETE FROM berita WHERE id_berita = ?;");
$kueri->bind_param("i", $_GET["id"]);
$hasil = $kueri->execute();
if ($hasil) {
	$pemberitahuan = "Berita telah berhasil dihapus.";
} else {
	$pemberitahuan = "Berita gagal dihapus.";
}
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hapus Berita</title>
	<link rel="stylesheet" href="gaya.css">
</head>
<body>
	<nav>
		<a href="index.php">Halaman Depan</a> |
		<a href="daftar_berita.php">Daftar Berita</a> |
		<a href="buat_berita.php">Buat Berita Baru</a>
	</nav>
	<hr>
	<p style="color: blue;"><?= $pemberitahuan ?></p>
</body>
</html>
