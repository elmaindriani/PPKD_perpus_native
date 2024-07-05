<?php
session_start();

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['nama'])) {
    header("location: index.php?error=access-failed");
    exit;
}

include 'config/config.php';

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $id_anggota = $_POST['id_anggota'];
    $no_transaksi = $_POST['no_transaksi'];

    if (!empty($id_anggota)) {
        // Masukkan data ke tabel peminjam
        $insertPeminjam = mysqli_query($koneksi, "INSERT INTO peminjam (id_anggota, no_transaksi) VALUES ('$id_anggota', '$no_transaksi')");
        $id_peminjam = mysqli_insert_id($koneksi); // Dapatkan ID peminjam yang baru saja dimasukkan

        // Masukkan detail peminjaman
        foreach ($_POST['id_buku'] as $key => $id_buku) {
            $tgl_pinjam = $_POST['tgl_pinjam'][$key];
            $tgl_pengembalian = $_POST['tgl_pengembalian'][$key];

            $insertDetail = mysqli_query($koneksi, "INSERT INTO detail_peminjam (id_peminjam, id_buku, tgl_pinjam, tgl_pengembalian) 
                                                    VALUES ('$id_peminjam', '$id_buku', '$tgl_pinjam', '$tgl_pengembalian')");
        }

        // Redirect dengan notifikasi tambah berhasil
        header('location: peminjaman.php?tambah=berhasil');
        exit;
    }
}

// jika prameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM peminjam WHERE id='$id'");
    header('location:peminjaman.php?notif=delete=success');
}

// tampilkan semua data dari table user dimana id nya diambil dari params edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM peminjam WHERE id='$id'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $no_transaksi = $_POST['no_transaksi'];


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

$queryBuku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");

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
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-2">
                                            <label for="">No Transaksi</label>
                                            <input type="text" readonly name="no_transaksi" value="<?php echo $kode_transaksi ?>" class="form-control">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-sm-3 row">
                                            <button type="button" name="submit" class="btn btn-success btn-sm">Anggota Baru</button>

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
    <script>
        $('.btn-add').click(function() {
            let tbody = $('tbody');
            let newTr = "<tr>";
            newTr += "<td>";
            newTr += "<select class='form-control' name='id_buku[]'>";
            newTr += "<option>Pilih Buku</option>";
            <?php mysqli_data_seek($queryBuku, 0); ?>
            <?php while ($rowBuku = mysqli_fetch_assoc($queryBuku)) : ?>
                newTr += "<option value='<?php echo $rowBuku['id'] ?>'><?php echo $rowBuku['nama_buku'] ?></option>";
            <?php endwhile ?>
            newTr += "</select>";
            newTr += "</td>";
            newTr += "<td><input type='date' name='tgl_pinjam[]' class='form-control'></td>";
            newTr += "<td><input type='date' name='tgl_pengembalian[]' class='form-control'></td>";
            newTr += "<td><button type='button' class='btn btn-danger btn-remove'>Hapus</button></td>";
            newTr += "</tr>";
            tbody.append(newTr);
        });

        // Script untuk menghapus baris
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
        });
    </script>
    <script>
        var tambahButton = document.getElementsByName('submit')[0];
        tambahButton.addEventListener('click', function() {
            window.location.href = 'anggota.php';
        });
    </script>
</body>

</html>