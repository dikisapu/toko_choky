<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_user'];

$new_kode_suplier = ''; 

$message = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_get_last_kode = "SELECT kode_suplier FROM suplier ORDER BY kode_suplier DESC LIMIT 1";
    $result = $conn->query($sql_get_last_kode);
    $last_kode_suplier = 5000;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_kode_suplier = $row['kode_suplier'];
    }
    $kode_suplier = $last_kode_suplier + 1;

    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_telpon = $_POST['nomor_telpon'];
    $alamat = $_POST['alamat'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto_suplier"]["name"]);
    if (move_uploaded_file($_FILES["foto_suplier"]["tmp_name"], $target_file)) {
        $foto_suplier = basename($_FILES["foto_suplier"]["name"]);
        $sql = "INSERT INTO suplier (kode_suplier, nama_lengkap, nomor_telpon, alamat, foto_suplier)
                VALUES ('$kode_suplier', '$nama_lengkap', '$nomor_telpon', '$alamat', '$foto_suplier')";

        if ($conn->query($sql) === TRUE) {
            $message = "Data suplier berhasil ditambahkan."; 
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error; 
        }
    } else {
        $message = "Error uploading file.";
    }

    $conn->close();
} else {
    $sql_get_last_kode = "SELECT kode_suplier FROM suplier ORDER BY kode_suplier DESC LIMIT 1";
    $result = $conn->query($sql_get_last_kode);
    $last_kode_suplier = 5000; 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_kode_suplier = $row['kode_suplier'];
    }
    $new_kode_suplier = $last_kode_suplier + 1;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Menu Akun Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="dashboard.php">Toko Choky</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="navbar-nav me-auto my-2 my-lg-0">
            <div class="navbar-brand me-4 align-items-center">
                <h6 class="mb-0">Selamat datang, <?php echo $nama_user; ?>!</h6>
            </div>
        </div>
    </nav>



    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>

                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link" href="barang.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Barang
                        </a>

                        <a class="nav-link" href="barang_masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-alt-circle-down"></i></div>
                            Barang Masuk
                        </a>

                        <a class="nav-link" href="barang_keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-alt-circle-up"></i></div>
                            Barang Keluar
                        </a>

                        <a class="nav-link" href="suplier.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-gray-300"></i></div>
                            Suplier
                        </a>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt text-gray-300"></i></div>
                                Laporan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
                                <li><a class="dropdown-item" href="laporan_masuk.php">Laporan Masuk</a></li>
                                <li><a class="dropdown-item" href="laporan_keluar.php">Laporan Keluar</a></li>
                            </ul>
                        </li>

                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>

                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Barang</h1>
                    <!-- ini -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Barang</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($message)) : ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?php echo $message; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form action="tambah_suplier.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group mb-3">
                                            <label for="kode_suplier">Kode Suplier</label>
                                            <input type="text" class="form-control" id="kode_suplier" name="kode_suplier" value="<?php echo $new_kode_suplier; ?>" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="nama_lengkap">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="nomor_telpon">Nomor Telpon</label>
                                            <input type="text" class="form-control" id="nomor_telpon" name="nomor_telpon" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="foto_suplier">Foto Suplier</label>
                                            <input type="file" class="form-control" id="foto_suplier" name="foto_suplier" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>


            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>