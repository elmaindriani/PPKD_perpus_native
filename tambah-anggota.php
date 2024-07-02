<?php
session_start();

include 'config/config.php';

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
// jika button disubmit, ambil nilai dari form, nama, email, password
if (isset($_POST['simpan'])) {
    $namaAnggota = $_POST['nama_anggota'];
    $email = $_POST['email'];
    $no_tlp = $_POST['no_tlp'];

    // masukkan kedalam table user dimana kolom nama di ambil nilainya dari inputan nama
    $insertAnggota = mysqli_query($koneksi, "INSERT INTO anggota (nama_anggota, email, no_tlp) VALUES('$namaAnggota', '$email','$no_tlp')");
    header("location:anggota.php?notif=tambah-success");
    print_r($insertAnggota);
}

// jika prameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id='$id'");
    header('location:anggota.php?notif=delete=success');
}

// tampilkan semua data dari table user dimana id nya diambil dari params edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id='$id'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $namaAnggota = $_POST['nama_anggota'];
    $email = $_POST['email'];
    $no_tlp = $_POST['no_tlp'];

    $id = $_GET['edit'];

    // ubah data dari table user dimana nilai nama diambil dari inputan nama
    // dan nilai id usernya diambil dari parameter

    $edit = mysqli_query($koneksi, "UPDATE anggota SET nama_anggota='$namaAnggota', email='$email', no_tlp='$no_tlp' WHERE id = '$id'");
    header("location:anggota.php");

    $queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
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
                        <h1 class="h3 mb-4 text-black-800">Edit Anggota</h1>
                        <div class="card">
                            <div class="card-header">Edit Anggota</div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="">Nama Anggota</label>
                                        <input value="<?php echo $dataEdit['nama_anggota'] ?>" type="text" class="form-control" name="nama_anggota" placeholder="Masukkan Nama Anda...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Email</label>
                                        <input value="<?php echo $dataEdit['email'] ?>" type="email" class="form-control" name="email" placeholder="Masukkan Email Lengkap Anda...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">No Tlp</label>
                                        <input value="<?php echo $dataEdit['no_tlp'] ?>" type="number" class="form-control" name="no_tlp" placeholder="Masukkan No Telp Anda...">
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
                                        <a href="anggota.php" class="btn btn-danger">Kembali</a>
                                    </div>
                            </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <h1 class="h3 mb-4 text-black-800">Tambah Anggota</h1>
                        <div class="card-header">Tambah Anggota</div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_anggota" placeholder="Masukkan Nama Lengkap Anda...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Masukkan Email Lengkap Anda...">
                                </div>
                                <div class="mb-3">
                                    <label for="">No Tlp</label>
                                    <input value="<?php echo $dataEdit['no_tlp'] ?>" type="number" class="form-control" name="no_tlp" placeholder="Masukkan No Telp Anda...">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                    <a href="anggota.php" class="btn btn-danger">Kembali</a>
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