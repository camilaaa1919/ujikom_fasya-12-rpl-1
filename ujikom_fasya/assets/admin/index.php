<?php
include '../config/koneksi.php';
session_start();
$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400..700;1,400..700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sedan:ital@0;1&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
      body{
        background-color: #C7B7A3;
    }
    .pt-serif-regular {
  font-family: "PT Serif", serif;
  font-weight: 400;
  font-style: normal;
}
</style>

<body>
<nav class="navbar navbar-expand-lg shadow-sm p-3 mb-5 rounded pt-serif-regular" style="background-color:#6D2932">
        <div class="container">
            <a class="btn btn-dark" href="index.php" style="margin-right:20px"><b>Gallery</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="btn btn-dark pt-serif-regular" href="foto.php"><b>Foto</b></a>

                </div>
                <a href="../config/aksi_logout.php" class="btn btn-dark m-1"><b>Keluar</b></a>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <div class="row">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <div class="col-md-3">
                <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid']?>">
  
            
                    <div class="card shadow p-3 mb-5 shadow-lg p-3 mb-5 bg-body-primary rounded">
                        <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 12rem;">
                        <br><br>
                        <center>
                        <h4><?php echo $data['judulfoto'] ?></h4>
                        <p><?php echo $data['deskripsifoto'] ?></p>
                        <p class="fw-lighter"><?php echo $data['tanggalunggah'] ?></p>
                        </center>
                        <div class="card-footer text-center">

                            <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND
                            userid='$userid'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?>
                                <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka"><i class="bi bi-heart-fill text-danger"></i></a>

                            <?php } else { ?>
                                <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka"><i class="bi bi-heart"></i></a>
                            <?php }



                            $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            echo mysqli_num_rows($like) . ' Suka';
                            ?>
                            
                                                <!-- komentar -->
                                                <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="bi bi-chat-dots"></i> </a>
                                                <?php
                                                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                                echo mysqli_num_rows($jmlkomen) . ' Komentar';
                            ?>
                        </div>
                    </div>
                    </a>
                    <!-- Modal -->
    <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        
        <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>"><br>
                </div>
                <div class="col-md-4">
                    <div class="m-2">
                        <div class="overflow-auto">
                            <div class="sticky-top">
                                <strong><?php echo $data['judulfoto']?></strong>
                                <span class="badge bg-secondary"><?php echo $data['namalengkap']?></span>
                                <span class="badge bg-secondary"><?php echo $data['tanggalunggah']?></span>
                            </div>
                            <hr>
                            <p align="left">
                                <?php echo $data['deskripsifoto']?>
                            </p>
                            <hr>
                            <p></p>
                            <?php
                            $fotoid = $data['fotoid'];
                            $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid = user.userid WHERE komentarfoto.fotoid='$fotoid'");
                            while($row = mysqli_fetch_array($komentar)){
                            ?>
                            <p align="left">
                                <strong><?php echo $row['namalengkap']?></strong>
                                <?php echo $row['isikomentar'] ?>
                            </p>
                            <?php } ?>
                            <hr>
                            <div class="sticky-bottom">
                                <form action="../config/proses_komentar.php" method="POST">
                                    <div class="input-group">
                                        <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']?>">
                                        <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                                        <div class="input-group-prepend">
                                            <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
  </div>
</div>
                </div>
            <?php } ?>
        </div>
    </div>


    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>