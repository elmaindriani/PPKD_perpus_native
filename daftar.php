<?php
    session_start();
    include 'config/config.php';

    // mencari sebuah email dalam tabel user, jika ada dapat data
    // kalo tidak ada kembali ke login dengan pesan data tidak ditemukan
    // $_POST[] = Variabel sistem untuk mengambil nilai dari input dengan method post

    if (isset($_POST['daftar'])) { 
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $id_level = $_POST['id_level'];
    


       $insertUser = mysqli_query($koneksi, "INSERT INTO user (nama, email, id_level) VALUES('$nama','$email', '$id_level')");
       if ($insertUser) {
        header('location:daftar.php?success=daftar');
       }

    }

    // $gelombang = mysqli_query($koneksi, "SELECT * FROM gelombang WHERE aktif = 1 ORDER BY id DESC");
    // $dataGelombang = mysqli_fetch_assoc($gelombang);
            
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Daftar Peserta Perpus</title>

    <!-- Custom fonts for this template-->
    <link href="assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <?php if (isset($_GET['success'])) : ?>
                                       <div class="alert alert-success">Terimakasih Telah Mendaftar di PPKD Jakarta Pusat :)</div>
                                    <?php endif ?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Daftar Peserta Perpus</h1>
                                    </div>
                                    <form class="user" method="post">
                                    <div class="form-group">
                                            <input name="nama" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Your Name...">
                                        </div>
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input name="hp" type="number" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Your Number Phone...">
                                        </div>
                                        <div class="form-group">
                                            <input name="gender" type="radio" 
                                                id="exampleInputPassword" value="laki-laki">Laki-Laki
                                                <input name="gender" type="radio" 
                                                id="exampleInputPassword" value="Perempuan">Perempuan
                                        </div>
                                        <div class="form-group">
                                            <textarea name="alamat" id="text" class="form-control form-control" placeholder="Enter Your Address..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input name="pendidikan" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Your Education...">
                                        </div>
                                        <div class="form-group">
                                            <select name="id_jurusan" id="" class= "form-control">
                                                <option value="">Pilih Jurusan</option>
                                                <?php
                                                $queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                                ?>
                                                <?php while ($dataJurusan = mysqli_fetch_assoc($queryJurusan)) {?>
                                                    <option value="<?php echo $dataJurusan['id']?>"><?php echo $dataJurusan['nama_jurusan']?></option>
                                                <?php } ?>
                                               
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" readonly value="<?php echo $dataGelombang['nama_gelombang'] ?>" class="form-control" placeholder="nama_gelombang">
                                            <input type="hidden" name="id_gelombang" value="<?php echo $dataGelombang['id'] ?>">
                                        </div>
                                        <button name="daftar" type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar
                                        </button>
                                    
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/admin/vendor/js/sb-admin-2.min.js"></script>

</body>

</html>