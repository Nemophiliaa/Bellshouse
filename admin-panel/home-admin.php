<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header('Location: login-admin.php');
    exit;
}
require_once '../backend/connection.php';

// Stats
$total_destinasi = $conn->query("SELECT COUNT(*) as total FROM destinasi")->fetch_assoc()['total'];
$total_user = $conn->query("SELECT COUNT(*) as total FROM data_user")->fetch_assoc()['total'];
$total_pesanan = $conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc()['total'];
$total_kategori = $conn->query("SELECT COUNT(*) as total FROM kategori")->fetch_assoc()['total'];

// Revenue Stats
$total_pendapatan = $conn->query("SELECT SUM(total_bayar) as total FROM pesanan WHERE status != 'cancelled'")->fetch_assoc()['total'] ?? 0;
$pendapatan_bulan_ini = $conn->query("SELECT SUM(total_bayar) as total FROM pesanan WHERE status != 'cancelled' AND MONTH(tanggal_pemesanan) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_pemesanan) = YEAR(CURRENT_DATE())")->fetch_assoc()['total'] ?? 0;

// Top Destinations by Order Count
$top_destinasi_query = $conn->query("SELECT d.nama_destinasi, COUNT(p.id) as jumlah_pesanan, SUM(p.total_bayar) as total_pendapatan 
                                     FROM pesanan p 
                                     JOIN destinasi d ON p.destinasi = d.id 
                                     WHERE p.status != 'cancelled'
                                     GROUP BY p.destinasi 
                                     ORDER BY jumlah_pesanan DESC 
                                     LIMIT 5");

// Recent Orders
$recent_orders = $conn->query("SELECT p.*, d.nama_destinasi, u.nama as nama_user 
                               FROM pesanan p 
                               JOIN destinasi d ON p.destinasi = d.id 
                               JOIN data_user u ON p.id_data_user = u.id 
                               ORDER BY p.tanggal_pemesanan DESC 
                               LIMIT 5");

// Order Status Count
$pesanan_pending = $conn->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'pending'")->fetch_assoc()['total'];
$pesanan_confirmed = $conn->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'confirmed'")->fetch_assoc()['total'];
$pesanan_completed = $conn->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'completed'")->fetch_assoc()['total'];
$pesanan_cancelled = $conn->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'cancelled'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BellsHouse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">BellsHouse Admin Panel</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm">Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong></span>
                <a href="logout-admin.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg hover:bg-gray-100 font-medium">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

        <!-- Stats Cards Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Destinasi</p>
                        <h3 class="text-3xl font-bold text-orange-600 mt-2"><?= $total_destinasi ?></h3>
                    </div>
                    <div class="bg-orange-100 rounded-full p-4">
                        <i class="fas fa-map-marked-alt text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total User</p>
                        <h3 class="text-3xl font-bold text-blue-600 mt-2"><?= $total_user ?></h3>
                    </div>
                    <div class="bg-blue-100 rounded-full p-4">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2"><?= $total_pesanan ?></h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-shopping-cart text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Kategori</p>
                        <h3 class="text-3xl font-bold text-purple-600 mt-2"><?= $total_kategori ?></h3>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <i class="fas fa-tags text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue & Order Status Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Pendapatan -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg shadow-lg p-6 text-white hover:shadow-2xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-2">Total Pendapatan</p>
                        <h3 class="text-3xl font-bold">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
                        <p class="text-emerald-100 text-xs mt-2">
                            <i class="fas fa-calendar-alt mr-1"></i>Semua Waktu
                        </p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-money-bill-wave text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white hover:shadow-2xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-2">Pendapatan Bulan Ini</p>
                        <h3 class="text-3xl font-bold">Rp <?= number_format($pendapatan_bulan_ini, 0, ',', '.') ?></h3>
                        <p class="text-blue-100 text-xs mt-2">
                            <i class="fas fa-chart-line mr-1"></i><?= date('F Y') ?>
                        </p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-hand-holding-usd text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Status Pesanan Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <h4 class="text-gray-700 font-semibold mb-4">Status Pesanan</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><i class="fas fa-clock text-yellow-500 mr-2"></i>Pending</span>
                        <span class="font-bold text-yellow-600"><?= $pesanan_pending ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Confirmed</span>
                        <span class="font-bold text-blue-600"><?= $pesanan_confirmed ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><i class="fas fa-check-double text-green-500 mr-2"></i>Completed</span>
                        <span class="font-bold text-green-600"><?= $pesanan_completed ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><i class="fas fa-times-circle text-red-500 mr-2"></i>Cancelled</span>
                        <span class="font-bold text-red-600"><?= $pesanan_cancelled ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Destinations & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top 5 Destinasi Terpopuler -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top 5 Destinasi Terpopuler
                    </h3>
                </div>
                <div class="space-y-3">
                    <?php 
                    $rank = 1;
                    while($dest = $top_destinasi_query->fetch_assoc()): 
                        $medal_color = $rank == 1 ? 'text-yellow-500' : ($rank == 2 ? 'text-gray-400' : ($rank == 3 ? 'text-amber-700' : 'text-gray-600'));
                    ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center gap-3 flex-1">
                                <span class="<?= $medal_color ?> font-bold text-xl w-6"><?= $rank ?>.</span>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?= htmlspecialchars($dest['nama_destinasi']) ?></p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-shopping-bag mr-1"></i><?= $dest['jumlah_pesanan'] ?> Pesanan
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">Rp <?= number_format($dest['total_pendapatan'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    <?php 
                    $rank++;
                    endwhile; 
                    ?>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-history text-blue-500 mr-2"></i>Pesanan Terbaru
                    </h3>
                    <a href="manage-pesanan.php" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua →</a>
                </div>
                <div class="space-y-3">
                    <?php while($order = $recent_orders->fetch_assoc()): 
                        $status_colors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800'
                        ];
                        $status_class = $status_colors[$order['status']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($order['nama_user']) ?></p>
                                <p class="text-xs text-gray-600"><?= htmlspecialchars($order['nama_destinasi']) ?></p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-calendar mr-1"></i><?= date('d M Y', strtotime($order['tanggal_pemesanan'])) ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="<?= $status_class ?> px-2 py-1 rounded text-xs font-medium"><?= ucfirst($order['status']) ?></span>
                                <p class="text-sm font-bold text-gray-700 mt-1">Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="manage-destinasi.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg p-4 group-hover:scale-110 transition">
                        <i class="fas fa-map-marked-alt text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-orange-600">Kelola Destinasi</h3>
                        <p class="text-gray-600 text-sm mt-1">Tambah, edit, hapus destinasi wisata</p>
                    </div>
                </div>
            </a>

            <a href="manage-user.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 group-hover:scale-110 transition">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600">Kelola User</h3>
                        <p class="text-gray-600 text-sm mt-1">Lihat dan kelola data pengguna</p>
                    </div>
                </div>
            </a>

            <a href="manage-pesanan.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 group-hover:scale-110 transition">
                        <i class="fas fa-shopping-cart text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-green-600">Kelola Pesanan</h3>
                        <p class="text-gray-600 text-sm mt-1">Monitor dan kelola pesanan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Quick Link -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
            <div class="flex flex-wrap gap-3">
                <a href="../src/pages/home.php" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg transition">
                    <i class="fas fa-external-link-alt mr-2"></i>Lihat Website
                </a>
                <a href="manage-destinasi.php" class="bg-orange-100 hover:bg-orange-200 text-orange-800 px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Destinasi Baru
                </a>
            </div>
        </div>
    </div>
</body>
</html>
