<?php
session_start();
include 'config/config.php';
// kalo session tidak ada, tolong redirect ke login

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
                    <h1 class="h3 mb-4 text-gray-800">Data Buku</h1>
                    <div align="right">
                        <a href="tambah-anggota.php" class="btn btn-primary mb-3">Tambah Buku</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="datatables" aria-describedby="datatables_info">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Penerbit</th>
                                    <th>Qty</th>
                                    <th>Deskripsi</th>
                                    <th>Penulis</th>
                                    <th>Genre</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($dataBuku = mysqli_fetch_assoc($queryBuku)) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $dataBuku['nama_buku'] ?></td>
                                        <td><?php echo $dataBuku['penerbit'] ?></td>
                                        <td><?php echo $dataBuku['qty'] ?></td>
                                        <td><?php echo $dataBuku['deskripsi'] ?></td>
                                        <td><?php echo $dataBuku['penulis'] ?></td>
                                        <td><?php echo $dataBuku['genre'] ?></td>
                                        <td>
                                            <a href="tambah-buku.php?edit=<?php echo $dataBuku['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a onclick="return confirm('Apakah Anda yakin akan menghapus Data ini?')" href="tambah-buku.php?delete=<?php echo $dataBuku['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <?php include 'inc/footer.php'; ?>
            <!-- End of Footer -->

            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

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