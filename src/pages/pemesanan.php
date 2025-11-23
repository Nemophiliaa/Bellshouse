<?php
session_start();
require_once '../../backend/db.php';

// Check if user logged in
if(!isset($_SESSION['user_id'])){
    $_SESSION['login_error'] = 'Silakan login terlebih dahulu!';
    header('Location: login.php');
    exit;
}

// Get parameters from detail page
$id_destinasi = isset($_GET['id']) ? $_GET['id'] : '';
$tgl_berangkat = isset($_GET['tgl_berangkat']) ? $_GET['tgl_berangkat'] : '';
$tgl_pulang = isset($_GET['tgl_pulang']) ? $_GET['tgl_pulang'] : '';
$jumlah_orang = isset($_GET['jumlah_orang']) ? (int)$_GET['jumlah_orang'] : 1;

// Validation
if(!$id_destinasi || !$tgl_berangkat || !$tgl_pulang || $jumlah_orang < 1 || $jumlah_orang > 5){
    header('Location: home.php');
    exit;
}

// Get destinasi data
$destinasi = db_fetch_one($conn, 'SELECT * FROM destinasi WHERE id = ?', [$id_destinasi]);
if(!$destinasi){
    header('Location: home.php');
    exit;
}

// Get user data
$user = db_fetch_one($conn, 'SELECT * FROM data_user WHERE id = ?', [$_SESSION['user_id']]);

// Calculate total
$total_bayar = $destinasi['harga'] * $jumlah_orang;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - BellsHouse</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-[poppins] bg-gradient-to-b from-orange-50 to-white">
    <?php include '../components/navigation.php'; ?>


    <main class="py-16">
        <div class="w-[90%] max-w-6xl mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="detail-destinasi.php?id=<?= $id_destinasi ?>" class="text-orange-600 hover:text-orange-700 mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Detail Pemesanan</h1>
                <p class="text-slate-600">Lengkapi data peserta untuk melanjutkan pemesanan</p>
            </div>

            <form action="../../backend/proses-pesanan.php" method="POST" class="grid lg:grid-cols-3 gap-8">
                
                <!-- Hidden inputs -->
                <input type="hidden" name="id_destinasi" value="<?= $id_destinasi ?>">
                <input type="hidden" name="tgl_berangkat" value="<?= $tgl_berangkat ?>">
                <input type="hidden" name="tgl_pulang" value="<?= $tgl_pulang ?>">
                <input type="hidden" name="jumlah_orang" value="<?= $jumlah_orang ?>">
                <input type="hidden" name="total_bayar" value="<?= $total_bayar ?>">

                <!-- Left: Form Data Peserta -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Info Pemesan (dari user login) -->
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">
                            <i class="fas fa-user text-orange-500 mr-2"></i>Data Pemesan
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4 text-slate-700">
                            <div>
                                <p class="text-sm text-slate-500">Nama Lengkap</p>
                                <p class="font-medium"><?= htmlspecialchars($user['nama']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Email</p>
                                <p class="font-medium"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">No. Telepon</p>
                                <p class="font-medium"><?= htmlspecialchars($user['no_tlp']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Alamat</p>
                                <p class="font-medium"><?= htmlspecialchars($user['alamat']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Data Peserta -->
                    <?php for($i = 1; $i <= $jumlah_orang; $i++): ?>
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">
                            <i class="fas fa-hiking text-orange-500 mr-2"></i>Data Peserta <?= $i ?>
                        </h2>
                        
                        <div class="space-y-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
                                <input type="text" name="peserta[<?= $i ?>][nama_lengkap]" required
                                       value="<?= $i == 1 ? htmlspecialchars($user['nama']) : '' ?>"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all"
                                       placeholder="Nama sesuai identitas">
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Jenis Kelamin -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin *</label>
                                    <select name="peserta[<?= $i ?>][jenis_kelamin]" required
                                            class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all">
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <!-- Tipe Peserta -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Peserta *</label>
                                    <select name="peserta[<?= $i ?>][tipe_peserta]" required
                                            class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all">
                                        <option value="">Pilih</option>
                                        <option value="dewasa" selected>Dewasa</option>
                                        <option value="anak">Anak-anak</option>
                                    </select>
                                </div>
                            </div>

                            <!-- No Identitas -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No. Identitas (KTP/Passport) *</label>
                                <input type="text" name="peserta[<?= $i ?>][no_identitas]" required
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all"
                                       placeholder="Nomor KTP atau Passport"
                                       pattern="[0-9]{16}|[A-Z0-9]{6,9}"
                                       title="Masukkan 16 digit KTP atau nomor Passport yang valid">
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>

                    <!-- Terms & Conditions -->
                    <div class="bg-orange-50 rounded-2xl p-6 border border-orange-200">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" required class="mt-1 w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                            <span class="text-sm text-slate-700">
                                Saya menyetujui <a href="#" class="text-orange-600 hover:underline font-medium">syarat dan ketentuan</a> yang berlaku dan bertanggung jawab atas kebenaran data yang saya berikan.
                            </span>
                        </label>
                    </div>

                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-xl sticky top-20">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Ringkasan Pemesanan</h2>
                        
                        <!-- Destinasi Info -->
                        <div class="mb-4 pb-4 border-b border-slate-200">
                            <img src="../../backend/img/<?= htmlspecialchars($destinasi['foto']) ?>" 
                                 alt="<?= htmlspecialchars($destinasi['nama_destinasi']) ?>"
                                 class="w-full h-32 object-cover rounded-xl mb-3">
                            <h3 class="font-bold text-slate-800"><?= htmlspecialchars($destinasi['nama_destinasi']) ?></h3>
                        </div>

                        <!-- Details -->
                        <div class="space-y-3 text-sm mb-4">
                            <div class="flex justify-between">
                                <span class="text-slate-600"><i class="fas fa-calendar mr-2 text-orange-500"></i>Keberangkatan</span>
                                <span class="font-medium text-slate-800"><?= date('d M Y', strtotime($tgl_berangkat)) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600"><i class="fas fa-calendar-check mr-2 text-orange-500"></i>Kepulangan</span>
                                <span class="font-medium text-slate-800"><?= date('d M Y', strtotime($tgl_pulang)) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600"><i class="fas fa-users mr-2 text-orange-500"></i>Jumlah Peserta</span>
                                <span class="font-medium text-slate-800"><?= $jumlah_orang ?> Orang</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-2 py-4 border-y border-slate-200 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Harga per orang</span>
                                <span class="text-slate-800">Rp <?= number_format($destinasi['harga'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Jumlah peserta</span>
                                <span class="text-slate-800">x<?= $jumlah_orang ?></span>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="flex justify-between items-center py-4">
                            <span class="text-lg font-bold text-slate-800">Total Bayar</span>
                            <span class="text-2xl font-bold text-orange-600">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full py-4 rounded-xl text-white text-lg font-semibold bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                            <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pemesanan
                        </button>

                        <p class="text-xs text-center text-slate-500 mt-3">
                            <i class="fas fa-shield-alt mr-1"></i>Pembayaran dilakukan setelah konfirmasi
                        </p>
                    </div>
                </div>

            </form>

        </div>
    </main>

    <?php include '../components/footer.php'; ?>
    <script src="../../js/main.js" type="module"></script>
</body>
</html>
