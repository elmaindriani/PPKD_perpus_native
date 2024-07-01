<?php
    session_start();

    
    // kalo session tidak ada, tolong redirect ke login
    if (!isset($_SESSION['nama'])) {
        header("location:index.php?error=access-failed");
    }
    include 'config/config.php';
    $queryUser = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");
    // jika button disubmit, ambil nilai dari form, nama, email, password
    if (isset($_POST['simpan'])) {
        $namaLevel = $_POST['nama_level'];


        // masukkan kedalam table user dimana kolom nama di ambil nilainya dari inputan nama
        $insertLevel = mysqli_query($koneksi, "INSERT INTO level (nama_level) VALUES('$namaLevel')");
        header("location:level.php?notif=tambah-success");
    }

    // jika prameter delete ada, buat perintah/query delete
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $delete = mysqli_query($koneksi, "DELETE FROM level WHERE id='$id'");
        header('location:level.php?notif=delete=success');
    }

    // tampilkan semua data dari table user dimana id nya diambil dari params edit
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $queryEdit = mysqli_query($koneksi, "SELECT * FROM level WHERE id='$id'");
        $dataEdit = mysqli_fetch_assoc($queryEdit);
         
    }

    if (isset($_POST['edit'])) {
        $namaLevel = $_POST['nama_level'];


        $id = $_GET['edit'];

        // ubah data dari table user dimana nilai nama diambil dari inputan nama
        // dan nilai id usernya diambil dari parameter

        $edit = mysqli_query($koneksi, "UPDATE level SET nama_level='$namaLevel' WHERE id = '$id'");
    } 

?>

<!DOCTYPE html>
<html lang="en">



<?php include 'inc/head.php'; ?>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <!-- Sidebar -->
       <?php include 'inc/sidebar.php';?>
       <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

        <!-- Topbar -->
        <?php include 'inc/navbar.php';?>
        <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php if(isset($_GET['edit'])) { ?>
                        <h1 class="h3 mb-4 text-black-800">Edit Level</h1>
                        <div class="card">
                        <div class="card-header">Edit Level</div>
                        <div class="card-body">
                            <form action=""method="post">
                                <div class="mb-3">
                                    <label for="">Nama Level</label>
                                    <input value="<?php echo $dataEdit['nama_level']?>" type="text" class= "form-control" name="nama_level" placeholder= "Masukkan Nama Level...">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class= "btn btn-primary" name="edit" value="Ubah">
                                    <a href="level.php" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    <?php }else{ ?>
 
                        <h1 class="h3 mb-4 text-black-800">Tambah Level</h1>
                    <div class="card-header">Tambah Level</div>
                        <div class="card-body">
                            <form action=""method="POST">
                                <div class="mb-3">
                                    <label for="">Nama Level</label>
                                    <input type="text" class= "form-control" name="nama_level" placeholder= "Masukkan Nama Level...">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class= "btn btn-primary" name="simpan" value="Simpan">
                                    <a href="level.php" class="btn btn-danger">Kembali</a>
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
            <?php include 'inc/footer.php';?>
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
    <?php include 'inc/modal-logout.php';?>

    <!-- Bootstrap core JavaScript-->
    <?php include 'inc/js.php';?>

</body>

</html>