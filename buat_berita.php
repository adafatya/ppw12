<?php
require("sambungan.php");

$pemberitahuan = "";

if (isset($_POST["judul"], $_POST["baris_kepala"], $_POST["isi"],
		$_POST["pengirim"], $_POST["id_kategori"])) {
	$kueri = $sambungan->prepare("INSERT INTO berita 
			(judul, baris_kepala, isi, pengirim, id_kategori) 
			VALUES (?, ?, ?, ?, ?);");
	$kueri->bind_param("ssssi",
			$_POST["judul"], $_POST["baris_kepala"], $_POST["isi"],
			$_POST["pengirim"], $_POST["id_kategori"]);
	$hasil = $kueri->execute();
	if ($hasil) {
		$pemberitahuan = "Berita telah berhasil ditambahkan.";
	} else {
		$pemberitahuan = "Berita gagal ditambahkan.";
	}
}

$daftar_kategori = $sambungan->query("SELECT id_kategori, nama_kategori 
		FROM kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Buat Berita Baru</title>
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
?>
	<h1>Buat Berita Baru</h1>
	<form action="" method="post">
		<label for="judul">Judul berita:</label>
		<input type="text" name="judul" id="judul" required autofocus>
		<label for="baris_kepala">Baris kepala:</label>
		<textarea name="baris_kepala" id="baris_kepala" required></textarea>
		<label for="isi">Isi berita:</label>
		<textarea name="isi" id="isi" required></textarea>
		<label for="pengirim">Pengirim:</label>
		<input type="text" name="pengirim" id="pengirim">
		<label for="id_kategori">Kategori:</label>
		<select name="id_kategori" id="id_kategori" required>
<?php
while ($kategori = $daftar_kategori->fetch_array()) {
?>
			<option value="<?= $kategori["id_kategori"] ?>"><?= $kategori["nama_kategori"] ?></option>
<?php
}
?>
		</select>
		<input type="submit" value="Buat">
		<input type="reset" value="Atur ulang">
	</form>
</body>
</html>
