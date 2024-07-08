<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_user'];
include 'config.php';

$sql_total_barang = "SELECT COUNT(*) AS total_barang FROM barang";
$sql_total_barang_keluar = "SELECT COUNT(*) AS total_barang_keluar FROM barang_keluar";
$sql_total_barang_masuk = "SELECT COUNT(*) AS total_barang_masuk FROM barang_masuk";
$sql_total_suplier = "SELECT COUNT(*) AS total_suplier FROM suplier";

$result_total_barang = $conn->query($sql_total_barang);
$result_total_barang_keluar = $conn->query($sql_total_barang_keluar);
$result_total_barang_masuk = $conn->query($sql_total_barang_masuk);
$result_total_suplier = $conn->query($sql_total_suplier);

$total_barang = $result_total_barang->fetch_assoc()['total_barang'];
$total_barang_keluar = $result_total_barang_keluar->fetch_assoc()['total_barang_keluar'];
$total_barang_masuk = $result_total_barang_masuk->fetch_assoc()['total_barang_masuk'];
$total_suplier = $result_total_suplier->fetch_assoc()['total_suplier'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
                    <h1 class="mt-4">Dashboard</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Barang
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_barang; ?> Barang
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Barang Keluar
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_barang_keluar; ?> Data
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Barang Masuk
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_barang_masuk; ?> Data
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Suplier
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_suplier; ?> Data
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between">
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

</div>