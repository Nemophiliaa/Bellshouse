<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    exit('Unauthorized');
}

require_once '../backend/connection.php';

$id_pesanan = isset($_GET['id_pesanan']) ? $_GET['id_pesanan'] : '';

if(!$id_pesanan){
    echo '<div class="text-center text-red-600"><p>ID Pesanan tidak valid</p></div>';
    exit;
}

// Get peserta data
$stmt = $conn->prepare("SELECT * FROM pesanan_peserta WHERE id_pesanan = ?");
$stmt->bind_param('s', $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
$peserta_list = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(empty($peserta_list)){
    echo '<div class="text-center text-gray-500"><p>Tidak ada data peserta</p></div>';
    exit;
}
?>

<div class="space-y-4">
    <?php foreach($peserta_list as $index => $peserta): ?>
    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-user-circle text-orange-500"></i>
            Peserta <?= $index + 1 ?>
        </h4>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Nama Lengkap</p>
                <p class="font-medium text-gray-900"><?= htmlspecialchars($peserta['nama_lengkap']) ?></p>
            </div>
            <div>
                <p class="text-gray-500">Jenis Kelamin</p>
                <p class="font-medium text-gray-900">
                    <?= $peserta['jenis_kelamin'] === 'L' ? '<i class="fas fa-mars text-blue-500 mr-1"></i>Laki-laki' : '<i class="fas fa-venus text-pink-500 mr-1"></i>Perempuan' ?>
                </p>
            </div>
            <div>
                <p class="text-gray-500">No. Identitas</p>
                <p class="font-medium text-gray-900"><?= htmlspecialchars($peserta['no_identitas']) ?></p>
            </div>
            <div>
                <p class="text-gray-500">Tipe Peserta</p>
                <p class="font-medium text-gray-900">
                    <?= $peserta['tipe_peserta'] === 'dewasa' ? '<i class="fas fa-user text-green-500 mr-1"></i>Dewasa' : '<i class="fas fa-child text-purple-500 mr-1"></i>Anak-anak' ?>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
