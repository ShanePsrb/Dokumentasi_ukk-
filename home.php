<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
  echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php';
  </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title> Website Galeri Foto </title>
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-info bg-info">
    <div class="container">
    <a class="navbar-brand"href="index.php"> Website Galeri Foto </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home.php" class="nav-link">Home</a>
        <a href="album.php" class="nav-link">Album</a>
        <a href="foto.php" class="nav-link"> Foto </a>
      </div>
    
      <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> Keluar </a>
    </div>
  </div>
</nav>

<div class="container mt-3" style="font-family:Bold">
  Album :
  <?php
  $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
  while($row = mysqli_fetch_array($album)){ ?>
  <a href="home.php?albumid=<?php echo $row['albumid']?>" class="btn btn-outline-primary"><?php echo $row['namaalbum']?></a>

  <?php } ?>

	<div class="row">
    <?php
    if (isset($_GET['albumid'])) { 
      $albumid = $_GET['albumid'];
      $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid ='$userid' AND albumid='$albumid'");
      while($data = mysqli_fetch_array($query)){ ?>
      <div class="col-md-3 mt-2">
			<div class="card">
            <img src="../assets/img/<?php echo $data['lokasifile']?>" class="img-fluid w-102 rounded" title="<?php echo $data['judulfoto']?>" style="height: 12rem;">
			<div class="card-footer text-center">
				
      <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    $cekbatalsuka = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-up m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-up m-1"></i></a>

                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like). ' ';
                    ?>
                    <?php
                    if (mysqli_num_rows($cekbatalsuka) == 1) { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-down m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-down m-1"></i></a>

                    <?php }
                    $unlike = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($unlike). ' ';
                    ?><br>
				<a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i> </a>
        <?php  
        $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
        echo mysqli_num_rows($jmlkomen).' Komentar';
        ?>
				</div>
			</div>
		</div>
    <?php } }else{
$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
while($data = mysqli_fetch_array($query)){
?>
<div class="col-md-3 mt-2">
			<div class="card">
            <img src="../assets/img/<?php echo $data['lokasifile']?>" class="card-img-top" title="<?php echo $data['judulfoto']?>" style="height: 12rem;">
			<div class="card-footer text-center">
				
      <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    $cekbatalsuka = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-up m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-up m-1"></i></a>

                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like). ' ';
                    ?>
                    <?php
                    if (mysqli_num_rows($cekbatalsuka) == 1) { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-down m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-down m-1"></i></a>

                    <?php }
                    $unlike = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($unlike). ' ';
                    ?><br>
				<a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i> </a>
        <?php  
        $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
        echo mysqli_num_rows($jmlkomen).' Komentar';
        ?>
				</div>
			</div>
		</div>
<?php } } ?>
</div>
 </div>
<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
<p>&copy; Galery Foto UKK  </p>
</footer>

<script type="text/javascript" src="../assets/js/boostrap.min.js"></script>
</body>
</html> 