<?php
session_start();
if(!isset($_SESSION['user_id'])){
    exit('Unauthorized');
}

require_once '../../backend/db.php';

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : '';
$user_id = $_SESSION['user_id'];

if(!$id_pesanan){
    echo '<div class="text-center text-red-600"><p>ID Pesanan tidak valid</p></div>';
    exit;
}

// Get pesanan detail
$pesanan = db_fetch_one($conn, 
    "SELECT pesanan.*, destinasi.nama_destinasi, destinasi.foto, destinasi.deskripsi,
            kota.kota, provinsi.provinsi, kategori.kategori
     FROM pesanan
     JOIN destinasi ON pesanan.destinasi = destinasi.id
     JOIN kota ON destinasi.id_kota = kota.id
     JOIN provinsi ON kota.id_provinsi = provinsi.id
     JOIN kategori ON destinasi.id_kategori = kategori.id
     WHERE pesanan.id = ? AND pesanan.id_data_user = ?", 
    [$id_pesanan, $user_id]
);

if(!$pesanan){
    echo '<div class="text-center text-red-600"><p>Pesanan tidak ditemukan</p></div>';
    exit;
}

// Get peserta list
$peserta_list = db_fetch_all($conn, 
    "SELECT * FROM pesanan_peserta WHERE id_pesanan = ?", 
    [$id_pesanan]
);

// Calculate duration
$date1 = new DateTime($pesanan['tanggal_keberangkatan']);
$date2 = new DateTime($pesanan['tanggal_kepulangan']);
$durasi = $date1->diff($date2)->days;

// Status badge
$status_badge = '';
switch($pesanan['status']) {
    case 'pending':
        $status_badge = '<span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">⏳ Menunggu Konfirmasi</span>';
        break;
    case 'confirmed':
        $status_badge = '<span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">✓ Dikonfirmasi</span>';
        break;
    case 'completed':
        $status_badge = '<span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">✓ Selesai</span>';
        break;
    case 'cancelled':
        $status_badge = '<span class="px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-semibold">✗ Dibatalkan</span>';
        break;
}
?>

<div class="space-y-6">
    <!-- ID & Status -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">ID Pesanan</p>
            <p class="text-xl font-bold text-gray-800"><?= htmlspecialchars($pesanan['id']) ?></p>
        </div>
        <div>
            <?= $status_badge ?>
        </div>
    </div>

    <!-- Destinasi -->
    <div class="border border-gray-200 rounded-xl p-4">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-map-marked-alt text-orange-500"></i>
            Destinasi Wisata
        </h4>
        <div class="flex gap-4">
            <img src="../../backend/img/<?= htmlspecialchars($pesanan['foto']) ?>" 
                 alt="<?= htmlspecialchars($pesanan['nama_destinasi']) ?>"
                 class="w-32 h-32 object-cover rounded-lg">
            <div class="flex-1">
                <h5 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($pesanan['nama_destinasi']) ?></h5>
                <p class="text-sm text-gray-500 mb-2">
                    <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                    <?= htmlspecialchars($pesanan['provinsi']) ?>, <?= htmlspecialchars($pesanan['kota']) ?>
                </p>
                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">
                    <?= htmlspecialchars($pesanan['kategori']) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Jadwal Perjalanan -->
    <div class="border border-gray-200 rounded-xl p-4">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-orange-500"></i>
            Jadwal Perjalanan
        </h4>
        <div class="grid md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Tanggal Keberangkatan</p>
                <p class="font-semibold text-gray-900"><?= date('d F Y', strtotime($pesanan['tanggal_keberangkatan'])) ?></p>
            </div>
            <div>
                <p class="text-gray-500">Tanggal Kepulangan</p>
                <p class="font-semibold text-gray-900"><?= date('d F Y', strtotime($pesanan['tanggal_kepulangan'])) ?></p>
            </div>
            <div>
                <p class="text-gray-500">Durasi</p>
                <p class="font-semibold text-gray-900"><?= $durasi ?> Hari <?= $durasi - 1 ?> Malam</p>
            </div>
        </div>
    </div>

    <!-- Peserta -->
    <div class="border border-gray-200 rounded-xl p-4">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-users text-orange-500"></i>
            Daftar Peserta (<?= count($peserta_list) ?> Orang)
        </h4>
        <div class="space-y-3">
            <?php foreach($peserta_list as $index => $peserta): ?>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="font-semibold text-gray-800 mb-2">
                    <i class="fas fa-user-circle text-gray-600 mr-2"></i>
                    Peserta <?= $index + 1 ?>
                </p>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars($peserta['nama_lengkap']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium text-gray-900">
                            <?= $peserta['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">No. Identitas</p>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars($peserta['no_identitas']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tipe</p>
                        <p class="font-medium text-gray-900"><?= ucfirst($peserta['tipe_peserta']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Rincian Pembayaran -->
    <div class="border border-orange-200 bg-orange-50 rounded-xl p-4">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-receipt text-orange-500"></i>
            Rincian Pembayaran
        </h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Jumlah Peserta</span>
                <span class="font-medium text-gray-900"><?= $pesanan['jumlah_orang'] ?> Orang</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Durasi</span>
                <span class="font-medium text-gray-900"><?= $durasi ?> Hari</span>
            </div>
            <div class="flex justify-between pt-3 border-t border-orange-200">
                <span class="text-gray-900 font-bold">Total Pembayaran</span>
                <span class="text-orange-600 font-bold text-lg">Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Tanggal Pemesanan -->
    <div class="text-center text-sm text-gray-500">
        <i class="fas fa-clock mr-1"></i>
        Dipesan pada <?= date('d F Y, H:i', strtotime($pesanan['tanggal_pemesanan'])) ?> WIB
    </div>
</div>
