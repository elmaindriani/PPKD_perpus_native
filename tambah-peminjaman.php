<?php
session_start();


// kalo session tidak ada, tolong redirect ke login
if (!isset($_SESSION['nama'])) {
    header("location:index.php?error=access-failed");
}
include 'config/config.php';
$queryUser = mysqli_query($koneksi, "SELECT * FROM peminjam ORDER BY id DESC");

// Jika button disubmit, ambil nilai dari form, nama, email, password
if (isset($_POST['simpan'])) {
    $nama_gelombang = $_POST['nama_gelombang'];

    // masukkan ke dalam table user dimana kolom nama di ambil nilainya dari input nama
    $insertUser = mysqli_query($koneksi, "INSERT INTO gelombang (nama_gelombang) VALUE('$nama_gelombang')");
    header('location:gelombang.php?notif=delete=success');
}

// jika prameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM gelombang WHERE id='$id'");
    header('location:gelombang.php?notif=delete=success');
}

// tampilkan semua data dari table user dimana id nya diambil dari params edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM gelombang WHERE id='$id'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $nama_gelombang = $_POST['nama_gelombang'];
    $aktif = $_POST['aktif'];


    $id = $_GET['edit'];

    // ubah data dari table user dimana nilai nama diambil dari inputan nama
    // dan nilai id usernya diambil dari parameter

    $edit = mysqli_query($koneksi, "UPDATE gelombang SET nama_gelombang='$nama_gelombang' WHERE id = '$id'");
    header('location:gelombang.php?notif=edit=success');
}

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");

$no_transaksi = mysqli_query($koneksi, "SELECT max(id) as kode FROM peminjam");

$data = mysqli_fetch_assoc($no_transaksi);
$huruf = "TR";
$urutan = $data['kode'];
$urutan++;

$kode_transaksi = $huruf . date("dmY") . sprintf("%03s", $urutan);

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
                        <h1 class="h3 mb-4 text-black-800">Edit Peminjaman</h1>
                        <div class="card">
                            <div class="card-header">Edit Peminjaman</div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="">Nama Peminjaman</label>
                                        <input value="<?php echo $dataEdit['nama_gelombang'] ?>" type="text" class="form-control" name="nama_gelombang" placeholder="Masukkan Nama Gelombang...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Aktif</label>
                                        <select name="aktif" id="" class="form-control">
                                            <option value="">--Pilih Status</option>
                                            <option <?php echo ($dataEdit['aktif'] == 1) ? 'selected' : '' ?> value="1">Aktif</option>
                                            <option <?php echo ($dataEdit['aktif'] == 0) ? 'selected' : '' ?> value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
                                        <a href="gelombang.php" class="btn btn-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>

                            <h1 class="h3 mb-4 text-black-800">Tambah Peminjaman</h1>
                            <div class="card-header">Tambah Peminjaman</div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="mb-3 row">
                                        <div class="col-sm-3">
                                            <label for="">Nama Anggota</label>
                                            <select name="id_anggota" id="" class="form-control">
                                                <option value="">Pilih Anggota</option>
                                                <?php while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                                    <option value="<?php echo $rowAnggota['id'] ?>"><?php echo $rowAnggota['nama_anggota'] ?></option>
                                                <?php endwhile ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-success btn-sm">Anggota Baru</button>
                                        </div>

                                        <div class="mb-3">
                                            <label for="">No Transaksi</label>
                                            <input type="text" readonly name="no_transaksi" value="<?php echo $kode_transaksi ?>" class="form-control">
                                        </div>

                                        <br><br>
                                        <div class="table-transaction">
                                            <div align="right" class="mb-3">
                                                <button type="button" class="btn btn-primary btn-sm btn-add">Tambah</button>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Buku</th>
                                                        <th>Tanggal Pinjam</th>
                                                        <th>Tanggal Kembali</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select name="id_buku" id="" name="id_buku[]" class="form-control">
                                                                <option value="">Pilih Buku</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="tanggal_pinjam[]" class="form-contol">
                                                        </td>
                                                        <td>
                                                            <input type="date" name="tanggal_pengembalian[]" class="form-contol">
                                                        </td>
                                                        <td>
                                                            Hapus
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                        <a href="peminjaman.php" class="btn btn-danger">Kembali</a>
                                    </div>
                            </div>
                            </form>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include 'inc/footer.php'; ?>
        <!-- End of Footer -->

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