<?php 
	
	include 'db.php';

	if(isset($_GET['idk'])){
		$delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '".$_GET['idk']."' ");
		echo '<script>window.location="data-kategori.php"</script>';
	}

	if(isset($_GET['idb'])){
		$buku = mysqli_query($conn, "SELECT gambar_buku FROM tb_buku WHERE buku_id =  '".$_GET['idb']."' ");
		$p = mysqli_fetch_object($buku);

		unlink('./buku/'.$p->gambar_buku);

		$delete = mysqli_query($conn, "DELETE FROM tb_buku WHERE buku_id = '".$_GET['idb']."' ");
		echo '<script>window.location="data-buku.php"</script>';
	}

?>