<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_user'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_get_last_id = "SELECT id_masuk FROM barang_masuk ORDER BY id_masuk DESC LIMIT 1";
    $result = $conn->query($sql_get_last_id);
    $last_id = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = (int)substr($row['id_masuk'], 2);
    }
    $new_id = 'BM' . str_pad($last_id + 1, 3, '0', STR_PAD_LEFT);

    $tanggal = $_POST['tanggal'];
    $suplier_id = $_POST['suplier'];
    $barang_id = $_POST['bahan'];
    $harga_bahan = $_POST['harga_bahan'];
    $qty = $_POST['qty'];
    $sub_jumlah = $harga_bahan * $qty;

    // Mendapatkan nama suplier berdasarkan ID
    $sql_get_suplier = "SELECT nama_lengkap FROM suplier WHERE kode_suplier = '$suplier_id'";
    $result_suplier = $conn->query($sql_get_suplier);
    $nama_suplier = '';
    if ($result_suplier->num_rows > 0) {
        $row_suplier = $result_suplier->fetch_assoc();
        $nama_suplier = $row_suplier['nama_lengkap'];
    }

    // Mendapatkan nama bahan berdasarkan ID
    $sql_get_barang = "SELECT nama_barang FROM barang WHERE barang_id = '$barang_id'";
    $result_barang = $conn->query($sql_get_barang);
    $nama_barang = '';
    if ($result_barang->num_rows > 0) {
        $row_barang = $result_barang->fetch_assoc();
        $nama_barang = $row_barang['nama_barang'];
    }

    // Insert into barang_masuk
    $sql = "INSERT INTO barang_masuk (id_masuk, tanggal, suplier_id, nama_suplier, bahan, harga_bahan, qty, sub_jumlah, total_jumlah)
            VALUES ('$new_id', '$tanggal', '$suplier_id', '$nama_suplier', '$nama_barang', '$harga_bahan', '$qty', '$sub_jumlah', '$sub_jumlah')";

    if ($conn->query($sql) === TRUE) {
        // Update total_harga and total_kuantitas in barang
        $sql_update_barang = "UPDATE barang 
                              SET total_harga = total_harga + $sub_jumlah, total_kuantitas = total_kuantitas + $qty 
                              WHERE barang_id = '$barang_id'";
        if ($conn->query($sql_update_barang) === TRUE) {
            $message = "Record baru berhasil ditambahkan";
            header('Location: tambah_barang_masuk.php');
        } else {
            echo "Error: " . $sql_update_barang . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $sql_get_last_id = "SELECT id_masuk FROM barang_masuk ORDER BY id_masuk DESC LIMIT 1";
    $result = $conn->query($sql_get_last_id);
    $last_id = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = (int)substr($row['id_masuk'], 2);
    }
    $new_id = 'BM' . str_pad($last_id + 1, 3, '0', STR_PAD_LEFT);
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
    <title>Tambah Barang Masuk</title>
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
                    <h1 class="mt-4">Tambah Barang Masuk</h1>
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
                                    <form action="tambah_barang_masuk.php" method="post">
                                        <div class="form-group">
                                            <label for="id_masuk">ID Masuk</label>
                                            <input type="text" id="id_masuk" name="id_masuk" value="<?php echo $new_id; ?>" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="suplier">Suplier</label>
                                            <select id="suplier" name="suplier" class="form-control" required>
                                                <?php
                                                $sql = "SELECT kode_suplier, nama_lengkap FROM suplier";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['kode_suplier'] . "'>" . $row['nama_lengkap'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bahan">Bahan</label>
                                            <select id="bahan" name="bahan" class="form-control" required>
                                                <?php
                                                $sql = "SELECT barang_id, nama_barang FROM barang";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['barang_id'] . "'>" . $row['nama_barang'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_bahan">Harga Bahan</label>
                                            <input type="number" id="harga_bahan" name="harga_bahan" class="form-control" oninput="calculateSubTotal()" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="qty">Kuantitas</label>
                                            <input type="number" id="qty" name="qty" class="form-control" oninput="calculateSubTotal()" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sub_jumlah">Sub Jumlah</label>
                                            <input type="text" id="sub_jumlah" name="sub_jumlah" class="form-control" readonly>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="barang_masuk.php" class="btn btn-danger">Kembali</a>
                                    </form>
                                </div>

                                <script>
                                    function calculateSubTotal() {
                                        var hargaBahan = document.getElementById('harga_bahan').value;
                                        var qty = document.getElementById('qty').value;
                                        var subTotal = hargaBahan * qty;
                                        document.getElementById('sub_jumlah').value = subTotal;
                                    }
                                </script>

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


</body>

</html>