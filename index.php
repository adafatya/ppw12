<?php
require("sambungan.php");

$kueri = "SELECT id_berita, judul, baris_kepala, pengirim, tanggal, nama_kategori
		FROM berita LEFT JOIN kategori ON berita.id_kategori = kategori.id_kategori
		ORDER BY tanggal DESC LIMIT 0, 5";
$daftar_berita = $sambungan->query($kueri);
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Berita</title>
	<link rel="stylesheet" href="gaya.css">
</head>
<body>
	<nav>
		<a href="index.php">Halaman Depan</a> |
		<a href="daftar_berita.php">Daftar Berita</a> |
		<a href="buat_berita.php">Buat Berita Baru</a>
	</nav>
	<hr>
	<h1>Berita Terbaru</h1>
<?php
$jumlah = 0;
while ($berita = $daftar_berita->fetch_array()) {
	$judul = htmlspecialchars($berita["judul"]);
	$baris_kepala = htmlspecialchars($berita["baris_kepala"]);
	$pengirim = htmlspecialchars($berita["pengirim"]);
	$tanggal = trim(strftime('%e %B %G %H.%M.%S', strtotime($berita["tanggal"])));
	$kategori = htmlspecialchars($berita["nama_kategori"]);
?>
	<article>
		<h2><a href="baca_berita.php?id=<?= $berita["id_berita"] ?>"><?= $judul ?></a></h2>
		<small>Penulis: <?= $pengirim ?> | Tanggal: <?= $tanggal ?> WIB</small>
		<p><?= $baris_kepala ?></p>
		<small>Kategori: <?= $kategori ?></small>
	</article>
<?php
	$jumlah ++;
}
if ($jumlah <= 0) {
?>
	<p>Belum ada berita.</p>
<?php
}
?>
</body>
</html>
