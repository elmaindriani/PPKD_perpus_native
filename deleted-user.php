<?php
require_once "config/config.php";
session_start();

$queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE deleted_at = 1 ORDER BY id DESC");

if (isset($_GET['delete_permanent'])) {
    $id = $_GET['delete_permanent'];

    // $delete = mysqli_query($koneksi, "DELETE FROM jurusan WHERE id='$id'");
    $soft_delete = mysqli_query($koneksi, "DELETE FROM jurusan WHERE id = '$id'");
    header('location:jurusan.php');
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
                    <h1 class="h3 mb-4 text-gray-800">Data Jurusan</h1>
                    <div align="right">
                        <a href="tambah-jurusan.php" class="btn btn-primary mb-3">Tambah Jurusan</a>
                    </div>
                    <div align="left"> 
                        <a href="deleted-jurusan.php" class="btn btn-primary mb-3">Hapus Jurusan</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Jurusan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($dataJurusan = mysqli_fetch_assoc($queryJurusan)) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $dataJurusan['nama_jurusan'] ?></td>
                                        <td>
                                            <a href="tambah-jurusan.php?deleted_at=<?php echo $dataJurusan['id'] ?>" class="btn btn-primary btn-sm">Restore</a>
                                            <a onclick="return confirm('Apakah Anda yakin akan menghapus Data ini?')" href="deleted-jurusan.php?delete_permanent=<?php echo $dataJurusan['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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