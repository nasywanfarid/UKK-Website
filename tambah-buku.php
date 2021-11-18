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
	<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
			<h3>Tambah Data Buku</h3>
			<div class="box">
				<form action="" method="POST" enctype="multipart/form-data">
					<select class="input-control" name="kategori" required>
						<option value="">--Pilih--</option>
						<?php 
							$kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
							while($r = mysqli_fetch_array($kategori)){
						?>
						<option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
						<?php } ?>
					</select>

					<input type="text" name="judul" class="input-control" placeholder="Judul Buku" required>
					<input type="text" name="pengarang" class="input-control" placeholder="Pengarang" required>
					<input type="text" name="penerbit" class="input-control" placeholder="Penerbit" required>
					<input type="file" name="gambar" class="input-control"  required>
					<textarea class="input-control" name="deskripsi" placeholder="Deskripsi" ></textarea> <br>
					

					<input type="submit" name="submit" value="Submit" class="btn">
				</form>
				<?php 
					if(isset($_POST['submit'])){

						//print_r($_FILES['gambar']);
						// menampung inputan dari form
						$kategori 	= $_POST['kategori'];
						$judul 		= $_POST['judul'];
						$pengarang 	= $_POST['pengarang'];
						$penerbit 	= $_POST['penerbit'];
						$deskripsi 	= $_POST['deskripsi'];
						
						//menampung data file yang diupload
						$filename = $_FILES['gambar']['name'];
						$tmp_name = $_FILES['gambar']['tmp_name'];

						$type1 = explode('.', $filename);
						$type2 = $type1[1];

						$newname = 'buku'. time().'.'.$type2;

						//menampung data format file yang diizinkan 
						$tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

						//vaalidasi format file
						if(!in_array($type2, $tipe_diizinkan)){
							//jika format file tidak ada didalam tipe diizinkan 
							echo '<script>alert("Format file tidak diizinkan")</script>';

						}else{
							//jika format file sesuai dengan yang ada di dalam array tipe diizinkan
							//proses upload file sekaligus insert ke database
							move_uploaded_file($tmp_name, './buku/'.$newname);
							$insert = mysqli_query($conn, "INSERT INTO tb_buku VALUES (
										null,
										'".$kategori."',
										'".$judul."',
										'".$pengarang."',
										'".$deskripsi."',
										'".$newname."',
										'".$penerbit."',

										null
											) ");
							if($insert){
								echo '<script>alert("Tambah data berhasil")</script>';
								echo '<script>window.location="data-buku.php"</script>';
							}else{
								echo 'Gagal '.mysqli_error($conn);
							}
						}

						
					}
				?>
			</div>
		</div>
	</div>

	<!-- footer -->
	<footer>
		<div class="container">
			<small>Copyright &copy; 2021 - BACA BUKU.</small>
		</div>
	</footer>
	<script>
        CKEDITOR.replace( 'deskripsi' );
    </script>
</body>
</html>