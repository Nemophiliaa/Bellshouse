<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header('Location: login-admin.php');
    exit;
}
require_once '../backend/connection.php';

// Auto-complete pesanan yang sudah melewati tanggal kepulangan
$auto_complete_query = "UPDATE pesanan SET status = 'completed' 
                        WHERE status = 'confirmed' 
                        AND tanggal_kepulangan < CURDATE()";
$conn->query($auto_complete_query);

// Handle status update
if(isset($_POST['update_status'])){
    $id_pesanan = $_POST['id_pesanan'];
    $new_status = $_POST['status'];
    
    // Cek status pesanan saat ini
    $check_stmt = $conn->prepare("SELECT status FROM pesanan WHERE id = ?");
    $check_stmt->bind_param('s', $id_pesanan);
    $check_stmt->execute();
    $current_status = $check_stmt->get_result()->fetch_assoc()['status'];
    $check_stmt->close();
    
    // Validasi: tidak bisa mengubah status jika sudah completed atau cancelled
    if($current_status === 'completed' || $current_status === 'cancelled'){
        $error_msg = "Status pesanan yang sudah " . strtoupper($current_status) . " tidak dapat diubah!";
    } else {
        $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id = ?");
        $stmt->bind_param('ss', $new_status, $id_pesanan);
        
        if($stmt->execute()){
            $success_msg = "Status pesanan berhasil diupdate!";
        } else {
            $error_msg = "Gagal update status: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle delete pesanan
if(isset($_GET['delete'])){
    $id_pesanan = $_GET['delete'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Delete peserta first (foreign key)
        $stmt1 = $conn->prepare("DELETE FROM pesanan_peserta WHERE id_pesanan = ?");
        $stmt1->bind_param('s', $id_pesanan);
        $stmt1->execute();
        $stmt1->close();
        
        // Delete pesanan
        $stmt2 = $conn->prepare("DELETE FROM pesanan WHERE id = ?");
        $stmt2->bind_param('s', $id_pesanan);
        $stmt2->execute();
        $stmt2->close();
        
        $conn->commit();
        $success_msg = "Pesanan berhasil dihapus!";
    } catch(Exception $e){
        $conn->rollback();
        $error_msg = "Gagal menghapus pesanan: " . $e->getMessage();
    }
}

// Get filter
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query pesanan dengan join
$sql = "SELECT pesanan.*, data_user.nama as nama_user, data_user.email, data_user.no_tlp,
               destinasi.nama_destinasi, destinasi.foto, kota.kota, provinsi.provinsi
        FROM pesanan
        JOIN data_user ON pesanan.id_data_user = data_user.id
        JOIN destinasi ON pesanan.destinasi = destinasi.id
        JOIN kota ON destinasi.id_kota = kota.id
        JOIN provinsi ON kota.id_provinsi = provinsi.id
        WHERE 1=1";

$params = [];
$types = '';

if($filter_status){
    $sql .= " AND pesanan.status = ?";
    $params[] = $filter_status;
    $types .= 's';
}

if($search){
    $sql .= " AND (pesanan.id LIKE ? OR data_user.nama LIKE ? OR destinasi.nama_destinasi LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

$sql .= " ORDER BY pesanan.tanggal_pemesanan DESC";

$stmt = $conn->prepare($sql);
if($params){
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$pesanan_list = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get statistics
$stats = [
    'total' => $conn->query("SELECT COUNT(*) as count FROM pesanan")->fetch_assoc()['count'],
    'pending' => $conn->query("SELECT COUNT(*) as count FROM pesanan WHERE status = 'pending'")->fetch_assoc()['count'],
    'confirmed' => $conn->query("SELECT COUNT(*) as count FROM pesanan WHERE status = 'confirmed'")->fetch_assoc()['count'],
    'completed' => $conn->query("SELECT COUNT(*) as count FROM pesanan WHERE status = 'completed'")->fetch_assoc()['count'],
    'cancelled' => $conn->query("SELECT COUNT(*) as count FROM pesanan WHERE status = 'cancelled'")->fetch_assoc()['count'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pesanan - Admin BellsHouse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">BellsHouse Admin Panel</h1>
            <div class="flex items-center gap-4">
                <a href="home-admin.php" class="hover:text-orange-200">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="manage-destinasi.php" class="hover:text-orange-200">
                    <i class="fas fa-map-marked-alt mr-2"></i>Destinasi
                </a>
                <a href="manage-pesanan.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-shopping-cart mr-2"></i>Pesanan
                </a>
                <a href="logout-admin.php" class="hover:text-orange-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Alert Messages -->
        <?php if(isset($success_msg)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i><?= $success_msg ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($error_msg)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i><?= $error_msg ?>
        </div>
        <?php endif; ?>

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Kelola Pesanan</h2>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800"><?= $stats['total'] ?></p>
            </div>
            <div class="bg-yellow-50 rounded-lg shadow p-4">
                <p class="text-yellow-700 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600"><?= $stats['pending'] ?></p>
            </div>
            <div class="bg-blue-50 rounded-lg shadow p-4">
                <p class="text-blue-700 text-sm">Confirmed</p>
                <p class="text-2xl font-bold text-blue-600"><?= $stats['confirmed'] ?></p>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-4">
                <p class="text-green-700 text-sm">Completed</p>
                <p class="text-2xl font-bold text-green-600"><?= $stats['completed'] ?></p>
            </div>
            <div class="bg-red-50 rounded-lg shadow p-4">
                <p class="text-red-700 text-sm">Cancelled</p>
                <p class="text-2xl font-bold text-red-600"><?= $stats['cancelled'] ?></p>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <input type="text" name="search" placeholder="Cari ID, Nama User, Destinasi..." 
                           value="<?= htmlspecialchars($search) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div class="min-w-[200px]">
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $filter_status === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $filter_status === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="completed" <?= $filter_status === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $filter_status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 font-medium">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="manage-pesanan.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 font-medium">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </form>
        </div>

        <!-- Pesanan Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemesan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Destinasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if(empty($pesanan_list)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Tidak ada pesanan ditemukan</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($pesanan_list as $pesanan): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($pesanan['id']) ?></td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars($pesanan['nama_user']) ?></p>
                                    <p class="text-gray-500"><?= htmlspecialchars($pesanan['email']) ?></p>
                                    <p class="text-gray-500"><?= htmlspecialchars($pesanan['no_tlp']) ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="../backend/img/<?= htmlspecialchars($pesanan['foto']) ?>" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900"><?= htmlspecialchars($pesanan['nama_destinasi']) ?></p>
                                        <p class="text-gray-500"><?= htmlspecialchars($pesanan['provinsi']) ?>, <?= htmlspecialchars($pesanan['kota']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="text-gray-500">Booking: <?= date('d/m/Y', strtotime($pesanan['tanggal_pemesanan'])) ?></p>
                                <p class="text-gray-900 font-medium"><?= date('d/m/Y', strtotime($pesanan['tanggal_keberangkatan'])) ?></p>
                                <p class="text-gray-500">s/d <?= date('d/m/Y', strtotime($pesanan['tanggal_kepulangan'])) ?></p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="showPeserta('<?= $pesanan['id'] ?>')" 
                                        class="text-orange-600 hover:text-orange-700 font-medium">
                                    <?= $pesanan['jumlah_orang'] ?> Orang
                                    <i class="fas fa-users ml-1"></i>
                                </button>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="inline">
                                    <input type="hidden" name="id_pesanan" value="<?= $pesanan['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" 
                                            <?= ($pesanan['status'] === 'completed' || $pesanan['status'] === 'cancelled') ? 'disabled' : '' ?>
                                            class="px-3 py-1 rounded-full text-sm font-medium border-0 <?= 
                                                $pesanan['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                                ($pesanan['status'] === 'confirmed' ? 'bg-blue-100 text-blue-700' :
                                                ($pesanan['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'))
                                            ?> <?= ($pesanan['status'] === 'completed' || $pesanan['status'] === 'cancelled') ? 'cursor-not-allowed opacity-75' : '' ?>">
                                        <option value="pending" <?= $pesanan['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $pesanan['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="completed" <?= $pesanan['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $pesanan['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="if(confirm('Yakin ingin menghapus pesanan ini?')) window.location.href='?delete=<?= $pesanan['id'] ?>'" 
                                        class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Detail Peserta -->
    <div id="pesertaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white">
                <h3 class="text-xl font-bold text-gray-800">Detail Peserta</h3>
                <button onclick="closePesertaModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="pesertaContent" class="p-6">
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-orange-500"></i>
                    <p class="mt-2 text-gray-600">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPeserta(idPesanan) {
            document.getElementById('pesertaModal').classList.remove('hidden');
            
            fetch('get-peserta.php?id_pesanan=' + idPesanan)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('pesertaContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('pesertaContent').innerHTML = 
                        '<div class="text-center text-red-600"><i class="fas fa-exclamation-circle text-4xl mb-2"></i><p>Error loading data</p></div>';
                });
        }

        function closePesertaModal() {
            document.getElementById('pesertaModal').classList.add('hidden');
        }

        // Close modal on outside click
        document.getElementById('pesertaModal').addEventListener('click', function(e) {
            if(e.target === this) closePesertaModal();
        });
    </script>
</body>
</html>
