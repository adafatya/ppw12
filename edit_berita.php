<?php
require("sambungan.php");

if (!isset($_GET["id"])) {
	header("Location: index.php");
	die;
}

$pemberitahuan = "";

if (isset($_POST["id_berita"], $_POST["judul"], $_POST["baris_kepala"],
		$_POST["isi"], $_POST["pengirim"], $_POST["id_kategori"])) {
	$kueri = $sambungan->prepare("UPDATE berita SET
			judul = ?,
			baris_kepala = ?,
			isi = ?,
			pengirim = ?,
			id_kategori = ?
			WHERE id_berita = ?;");
	$kueri->bind_param("ssssii",
			$_POST["judul"], $_POST["baris_kepala"], $_POST["isi"],
			$_POST["pengirim"], $_POST["id_kategori"], $_POST["id_berita"]);
	$hasil = $kueri->execute();
	if ($hasil) {
		$pemberitahuan = "Perubahan telah berhasil disimpan.";
	} else {
		$pemberitahuan = "Perubahan gagal disimpan.";
	}
}

$kueri = $sambungan->prepare("SELECT id_berita, judul, baris_kepala, isi, pengirim, id_kategori
		FROM berita WHERE id_berita = ?");
$kueri->bind_param("i", $_GET["id"]);
$kueri->execute();
$berita = $kueri->get_result()->fetch_array();

$daftar_kategori = $sambungan->query("SELECT id_kategori, nama_kategori 
		FROM kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Berita</title>
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
if (strlen($pemberitahuan) > 0) {
?>
		<p style="color: blue;"><?= $pemberitahuan ?></p>
		<hr>
<?php
}

if (!$berita) {
?>
	<h1>Berita tidak ditemukan.</h1>
<?php
} else {
?>
	<h1>Edit Berita</h1>
	<form action="" method="post">
		<input type="hidden" name="id_berita" value="<?= $berita["id_berita"] ?>">
		<label for="judul">Judul berita:</label>
		<input type="text" name="judul" id="judul" value="<?= $berita["judul"] ?>" required autofocus>
		<label for="baris_kepala">Baris kepala:</label>
		<textarea name="baris_kepala" id="baris_kepala" required><?= $berita["baris_kepala"] ?></textarea>
		<label for="isi">Isi berita:</label>
		<textarea name="isi" id="isi" required><?= $berita["isi"] ?></textarea>
		<label for="pengirim">Pengirim:</label>
		<input type="text" name="pengirim" id="pengirim" value="<?= $berita["pengirim"] ?>">
		<label for="id_kategori">Kategori:</label>
		<select name="id_kategori" id="id_kategori" required>
<?php
while ($kategori = $daftar_kategori->fetch_array()) {
	$terpilih = $kategori["id_kategori"] == $berita["id_kategori"] ? " selected" : "";
?>
			<option value="<?= $kategori["id_kategori"] ?>"<?= $terpilih ?>><?= $kategori["nama_kategori"] ?></option>
<?php
}
?>
		</select>
		<input type="submit" value="Simpan">
		<input type="reset" value="Atur ulang">
	</form>
<?php
}
?>
</body>
</html>
