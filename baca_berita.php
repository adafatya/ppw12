<?php
require("sambungan.php");

if (!isset($_GET["id"])) {
	header("Location: index.php");
	die;
}

if (isset($_POST["komentator"], $_POST["komentar"])) {
	$kueri = $sambungan->prepare("INSERT INTO komentar 
			(id_berita, komentator, komentar) 
			VALUES (?, ?, ?);");
	$kueri->bind_param("iss",
			$_GET["id"], $_POST["komentator"], $_POST["komentar"]);
	$hasil = $kueri->execute();
}

$kueri = $sambungan->prepare("SELECT judul, isi, pengirim, tanggal, nama_kategori
		FROM berita LEFT JOIN kategori ON berita.id_kategori = kategori.id_kategori
		WHERE id_berita = ?");
$kueri->bind_param("i", $_GET["id"]);
$kueri->execute();
$berita = $kueri->get_result()->fetch_array();

$kueri = "SELECT komentator, komentar, tanggal
		FROM komentar
		WHERE id_berita = ".$_GET["id"];
$daftar_komentar = $sambungan->query($kueri);

if ($berita) {
	$judul = htmlspecialchars($berita["judul"]);
}
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $judul ?> | Berita</title>
	<link rel="stylesheet" href="gaya.css">
</head>
<body>
	<nav>
		<a href="index.php">Halaman Depan</a> |
		<a href="daftar_berita.php">Daftar Berita</a> |
		<a href="buat_berita.php">Buat Berita Baru</a>
	</nav>
	<hr>
<?php
if (!$berita) {
?>
	<h1>Berita tidak ditemukan.</h1>
<?php
} else {
	$isi = str_replace("\r\n", "</p>\r\n<p>", htmlspecialchars($berita["isi"]));
	$pengirim = htmlspecialchars($berita["pengirim"]);
	$tanggal = trim(strftime('%e %B %G %H.%M.%S', strtotime($berita["tanggal"])));
	$kategori = htmlspecialchars($berita["nama_kategori"]);
?>
	<article>
		<h1><?= $judul ?></h1>
		<small>Penulis: <?= $pengirim ?> | Tanggal: <?= $tanggal ?> WIB</small>
		<p><?= $isi ?></p>
		<small>Kategori: <?= $kategori ?></small>
	</article>
<?php
}
?>
	<br /> <hr />
	<h2>Komentar</h2>
	<br />

	<form action="" method="post">
		<label for="komentator">Nama:</label>
		<input type="text" name="komentator" id="komentator" required>
		<label for="komentar">Komentar:</label>
		<textarea name="komentar" id="komentar" required>Komentar</textarea>
		<input type="submit" value="kirim">
	</form>

	<p><br></p>
	<p><br></p>
	<p><br></p>
	<p><br></p>

	<?php
	while ($komentar = $daftar_komentar->fetch_array()) {
		$komentator = htmlspecialchars($komentar["komentator"]);
		$komentarnya = str_replace("\r\n", "</p>\r\n<p>", htmlspecialchars($komentar["komentar"]));
		$tanggal = trim(strftime('%e %B %G %H.%M.%S', strtotime($komentar["tanggal"])));
	?>
		<br /> <hr />
		<h3>
			<?= $komentator ?>
		</h3>
		<small>Tanggal: <?= $tanggal ?> WIB</small><br>
		<p><?= $komentarnya ?></p>
	<?php
	}
	?>
</body>
</html>