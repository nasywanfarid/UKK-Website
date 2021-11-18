<?php 
	session_start();
	include 'db.php';
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="login.php"</script>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BACA BUKU</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
	<!-- header -->
	<header>
		<div class="container">
			<h1><a href="dashboard.php">BACA BUKU</a></h1>
			<ul>
				<li><a href="dashboard.php">Dashboard</a></li>
				<li><a href="profil.php">Profil</a></li>
				<li><a href="data-kategori.php">Kategori Buku</a></li>
				<li><a href="data-buku.php">Data Buku</a></li>
				<li><a href="keluar.php">Keluar</a></li>
			</ul>
		</div>
	</header>

	<!-- content -->
	<div class="section">
		<div class="container">
			<h2>Data Buku</h2>
			<div class="box">
				<p><a class="btn" href="tambah-buku.php">+ Tambah Data</a></p><br>
				<table border="1" cellspacing="0" class="table">
					<thead>
						<tr>
							<th width="40px">No</th>
							<th>Kategori</th>
							<th>Judul Buku</th>
							<th>Pengarang</th>
							<th>Penerbit</th>
							<th>Gambar</th>
							
							<th width="160px">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 1;
							$buku = mysqli_query($conn, "SELECT * FROM tb_buku LEFT JOIN tb_category USING (category_id) ORDER BY buku_id DESC");
							if(mysqli_num_rows($buku) > 0){
							while($row = mysqli_fetch_array($buku)){
						?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $row['category_name'] ?></td>
							<td><?php echo $row['judul_buku'] ?></td>
							<td><?php echo $row['pengarang'] ?></td>
							<td><?php echo $row['penerbit'] ?></td>
							<td><a href="buku/<?php echo $row['gambar_buku'] ?>" target="_blank"> <img src="buku/<?php echo $row['gambar_buku'] ?>" width="100px"> </a></td>
							
							<td>
								<a class="btn" href="edit-buku.php?id=<?php echo $row['buku_id'] ?>">Edit</a> <a class="btn" href="proses-hapus.php?idb=<?php echo $row['buku_id'] ?>" onclick="return confirm('Yakin ingin hapus ?')">Hapus</a>
							</td>
						</tr>
						<?php }}else{ ?>
							<tr>
								<td colspan="7">Tidak ada data</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- footer -->
	<footer>
		<div class="container">
			<small>Copyright &copy; 2020 - BACA BUKU.</small>
		</div>
	</footer>
</body>
</html>