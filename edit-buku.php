<?php 
	session_start();
	include 'db.php';
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="login.php"</script>';
	}

	$buku = mysqli_query($conn, "SELECT * FROM tb_buku WHERE buku_id = '".$_GET['id']."' ");
	$p = mysqli_fetch_object($buku);

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
			<h3>Edit Data Buku</h3>
			<div class="box">
				<form action="" method="POST" enctype="multipart/form-data">
					<select class="input-control" name="kategori" required>
						<option value="">--Pilih--</option>
						<?php 
							$kategori = mysqli_query($conn, "SELECT *FROM tb_category ORDER BY category_id DESC");
							while($r = mysqli_fetch_array($kategori)){
						?>
						<option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id)? 'selected': ''; ?> ><?php echo $r['category_name'] ?></option>
						<?php } ?>
					</select>

					<input type="text" name="judul" class="input-control" placeholder="Judul Buku" value="<?php echo $p->judul_buku ?>" required>
					<input type="text" name="pengarang" class="input-control" placeholder="Pengarang" value="<?php echo $p->pengarang ?>" required>
					<input type="text" name="penerbit" class="input-control" placeholder="Penerbit" value="<?php echo $p->penerbit ?>" required>

					<img src="buku/<?php echo $p->gambar_buku ?>" width=120px>
					<input type="hidden" name="foto" value="<?php echo $p->gambar_buku ?>">
					<input type="file" name="gambar" class="input-control">
					<textarea class="input-control" name="deskripsi" placeholder="Deskripsi" ><?php echo $p->deskripsi_buku ?></textarea> <br>
					

					<input type="submit" name="submit" value="Submit" class="btn">
				</form>
				<?php 
					if(isset($_POST['submit'])){

						// data inputan dari form
						$kategori 	= $_POST['kategori'];
						$judul 		= $_POST['judul'];
						$pengarang 	= $_POST['pengarang'];
						$penerbit 	= $_POST['penerbit'];
						$deskripsi 	= $_POST['deskripsi'];
						$foto 		= $_POST['foto'];

						// data gambar yang baru
						$filename = $_FILES['gambar']['name'];
						$tmp_name = $_FILES['gambar']['tmp_name'];

						// jika admin ganti gambar
						if($filename != ''){

							$type1 = explode('.', $filename);
							$type2 = $type1[1];

							$newname = 'buku'. time().'.'.$type2;

							//menampung data format file yang diizinkan 
							$tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

							if(!in_array($type2, $tipe_diizinkan)){
							//jika format file tidak ada didalam tipe diizinkan 
							echo '<script>alert("Format file tidak diizinkan")</script>';

							}else{
								unlink('./buku/'. $foto);
								move_uploaded_file($tmp_name, './buku/'.$newname);
								$namagambar = $newname;
							}

						}else{
							// jika admin tidak ganti gambar
							$namagambar = $foto;

						}
						
						//query update data buku
						$update = mysqli_query($conn, "UPDATE tb_buku SET 
										category_id = '".$kategori."',
										judul_buku 	= '".$judul."',
										pengarang 	= '".$pengarang."',
										deskripsi_buku = '".$deskripsi."',
										gambar_buku = '".$namagambar."',
										penerbit = '".$penerbit."'
										WHERE buku_id = '".$p->buku_id."' ");
						if($update){
							echo '<script>alert("Ubah data berhasil")</script>';
							echo '<script>window.location="data-buku.php"</script>';
						}else{
							echo 'Gagal '.mysqli_error($conn);
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