<?php
session_start();
include 'config/config.php';

// Jika session tidak ada, tolong redirect ke login
if (!isset($_SESSION['nama'])) {
    header("location:index.php?error=access-failed");
}

// function getUser($koneksi, $nama_level)
// {
//     $array_status = [1, 2, 3];
//     if (in_array($nama_level, $array_status)) {
//         $query = mysqli_query($koneksi, "SELECT * FROM level WHERE status = '$nama_level' AND deleted = 0");
//     } else {
//         $query = mysqli_query($koneksi, "SELECT * FROM level WHERE status = '$nama_level' AND deleted = 0");
//     }

//     $total = mysqli_num_rows($query);
//     return $total;
// }

// $queryUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN user ON level.id = user.id_level WHERE ORDER BY user.id DESC");

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
        <?php
        include 'inc/sidebar.php';
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include 'inc/navbar.php';
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
                    
                    <h1 class="h3 mb-4 text-gray-800">Data User</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($dataUser = mysqli_fetch_assoc($dataUser)) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $dataUser['nama'] ?></td>
                                        <td><?php echo $dataUser['Email'] ?></td>
                                        <td><?php echo $dataUser['Level'] ?></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#ubahStatus-<?php echo $dataUser['id'] ?>" href="#" class="btn btn-primary btn-sm">Edit</a>
                                            <a onclick="return confirm('Apakah Anda yakin akan menghapus Data ini?')" href="user.php?delete=<?php echo $dataUser['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <?php include 'modal-ubah-status.php' ?>

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