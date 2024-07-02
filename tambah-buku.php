<?php
session_start();

include 'config/config.php';

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
// jika button disubmit, ambil nilai dari form, nama, email, password
if (isset($_POST['simpan'])) {
    $namaBuku = $_POST['nama_buku'];
    $penerbit = $_POST['penerbit'];
    $qty = $_POST['qty'];
    $deskripsi = $_POST['deskripsi'];
    $penulis = $_POST['penulis'];
    $genre = $_POST['genre'];

    // masukkan kedalam table user dimana kolom nama di ambil nilainya dari inputan nama
    $insertBuku = mysqli_query($koneksi, "INSERT INTO buku (nama_buku, penerbit, qty, deskripsi, penulis, genre) VALUES('$namaBuku', '$penerbit','$qty', '$deskripsi', '$penulis', '$genre')");
    header("location:anggota.php?notif=tambah-success");
    print_r($insertBuku);
}

// jika prameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM buku WHERE id='$id'");
    header('location:buku.php?notif=delete=success');
}

// tampilkan semua data dari table user dimana id nya diambil dari params edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$id'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $namaBuku = $_POST['nama_buku'];
    $penerbit = $_POST['penerbit'];
    $qty = $_POST['qty'];
    $deskripsi = $_POST['deskripsi'];
    $penulis = $_POST['penulis'];
    $genre = $_POST['genre'];
    
    $id = $_GET['edit'];

    // ubah data dari table user dimana nilai nama diambil dari inputan nama
    // dan nilai id usernya diambil dari parameter

    $edit = mysqli_query($koneksi, "UPDATE buku SET nama_buku='$namaBuku', penerbit='$penerbit', qty='$qty', deskripsi='$deskripsi', penulis='$penulis', genre='$genre' WHERE id = '$id'");
    header("location:anggota.php");

    $queryBuku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'inc/head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'inc/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'inc/navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php if (isset($_GET['edit'])) { ?>
                        <h1 class="h3 mb-4 text-black-800">Edit Buku</h1>
                        <div class="card">
                            <div class="card-header">Edit Buku</div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="">Nama Buku</label>
                                        <input value="<?php echo $dataEdit['nama_buku'] ?>" type="text" class="form-control" name="nama_buku" placeholder="Masukkan Nama Buku...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Penerbit</label>
                                        <input value="<?php echo $dataEdit['penerbit'] ?>" type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Qty</label>
                                        <input value="<?php echo $dataEdit['qty'] ?>" type="number" class="form-control" name="qty" placeholder="Masukkan Jumlah Buku...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Deskripsi</label>
                                        <input value="<?php echo $dataEdit['deskripsi'] ?>" type="text" class="form-control" name="deskripsi" placeholder="Masukkan Deskripsi Buku...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Penulis</label>
                                        <input value="<?php echo $dataEdit['penulis'] ?>" type="text" class="form-control" name="penulis" placeholder="Masukkan Nama Penulis Buku...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Genre</label>
                                        <input value="<?php echo $dataEdit['genre'] ?>" type="text" class="form-control" name="genre" placeholder="Masukkan Jumlah Buku...">
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
                                        <a href="buku.php" class="btn btn-danger">Kembali</a>
                                    </div>
                            </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <h1 class="h3 mb-4 text-black-800">Tambah Buku</h1>
                        <div class="card-header">Tambah Buku</div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="">Nama Buku</label>
                                    <input type="text" class="form-control" name="nama_buku" placeholder="Masukkan Nama Buku...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Qty</label>
                                    <input value="<?php echo $dataEdit['qty'] ?>" type="number" class="form-control" name="qty" placeholder="Masukkan Jumlah Buku...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" placeholder="Masukkan Deskripsi Buku...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Penulis</label>
                                    <input type="text" class="form-control" name="penulis" placeholder="Masukkan Nama Penulis...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Genre</label>
                                    <input type="text" class="form-control" name="genre" placeholder="Masukkan Nama Penulis...">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                    <a href="buku.php" class="btn btn-danger">Kembali</a>
                                </div>
                        </div>
                        </form>
                </div>
            <?php } ?>

            </div>

            <!-- Footer -->
            <?php include 'inc/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include 'inc/modal-logout.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <?php include 'inc/js.php'; ?>

</body>

</html>