<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_user'];

function formatRupiah($number)
{
    return 'Rp. ' . number_format($number, 0, ',', '.');
}

if (isset($_GET['hapus'])) {
    $id_keluar = $_GET['hapus'];
    $sql_hapus = "DELETE FROM barang_keluar WHERE id_keluar = '$id_keluar'";
    if ($conn->query($sql_hapus) === TRUE) {
        echo "Record berhasil dihapus";
    } else {
        echo "Error: " . $sql_hapus . "<br>" . $conn->error;
    }
}

$sql = "SELECT id_keluar, tanggal, nama_suplier, qty, harga_bahan FROM barang_keluar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Daftar Barang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- ini -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="dashboard.php">Toko Choky</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="navbar-nav me-auto my-2 my-lg-0">
            <div class="navbar-brand me-4 align-items-center">
                <h6 class="mb-0">Selamat datang, <?php echo $nama_user; ?>!</h6>
                <!-- <p class="mb-0">User ID: <?php echo $user_id; ?></p> -->
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
                    <h1 class="mt-4">Daftar Barang Keluar </h1>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="tambah_barang_keluar.php" class="btn btn-primary btn-sm mb-3">Tambah Barang Keluar</a>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID Keluar</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Suplier</th>
                                                        <th>Qty</th>
                                                        <th>Harga Jual</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($result->num_rows > 0) : ?>
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <tr>
                                                                <td><?php echo $row['id_keluar']; ?></td>
                                                                <td><?php echo $row['tanggal']; ?></td>
                                                                <td><?php echo $row['nama_suplier']; ?></td>
                                                                <td><?php echo $row['qty']; ?></td>
                                                                <td><?php echo formatRupiah($row['harga_bahan']); ?></td>
                                                                <td>
                                                                    <a href="detail_barang_keluar.php?id=<?php echo $row['id_keluar']; ?>" class="btn btn-info btn-sm">Detail</a>
                                                                    <a href="?hapus=<?php echo $row['id_keluar']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="6">Tidak ada data ditemukan</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
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

</html