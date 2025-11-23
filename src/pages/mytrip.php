<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

require_once '../../backend/db.php';

$user_id = $_SESSION['user_id'];

// Get user pesanan with destinasi details
$pesanan_list = db_fetch_all($conn, 
    "SELECT pesanan.*, destinasi.nama_destinasi, destinasi.foto, destinasi.harga,
            kota.kota, provinsi.provinsi, kategori.kategori
     FROM pesanan
     JOIN destinasi ON pesanan.destinasi = destinasi.id
     JOIN kota ON destinasi.id_kota = kota.id
     JOIN provinsi ON kota.id_provinsi = provinsi.id
     JOIN kategori ON destinasi.id_kategori = kategori.id
     WHERE pesanan.id_data_user = ?
     ORDER BY pesanan.tanggal_pemesanan DESC", 
    [$user_id]
);

$total_pesanan = count($pesanan_list);

// Calculate duration
function hitungDurasi($tgl_berangkat, $tgl_pulang) {
    $date1 = new DateTime($tgl_berangkat);
    $date2 = new DateTime($tgl_pulang);
    $diff = $date1->diff($date2);
    return $diff->days;
}
?>
<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Trip - BellsHouse</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </head>

  <body class="font-[poppins] overflow-x-hidden">
    <?php if(isset($_SESSION['cancel_success'])): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= $_SESSION['cancel_success'] ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316'
        });
    </script>
    <?php unset($_SESSION['cancel_success']); endif; ?>
    
    <?php if(isset($_SESSION['cancel_error'])): ?>
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '<?= $_SESSION['cancel_error'] ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316'
        });
    </script>
    <?php unset($_SESSION['cancel_error']); endif; ?>
    
    <?php if(isset($_SESSION['cancel_warning'])): ?>
    <script>
        Swal.fire({
            title: 'Perhatian!',
            text: '<?= $_SESSION['cancel_warning'] ?>',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316'
        });
    </script>
    <?php unset($_SESSION['cancel_warning']); endif; ?>
    <!-- Navbar -->
    <?php include '../components/navigation.php' ?>

    <!-- Main -->
    <main class="pt-16 pb-24 space-y-10">
      <section>
        <!-- Header Section Start -->
        <header
          class="mx-auto w-[92%] lg:w-[85%] max-w-7xl bg-white border border-orange-300 rounded-3xl px-8 py-14 shadow-[0_10px_30px_rgba(0,0,0,0.08)] grid md:grid-cols-2 gap-10 items-center">
          <!-- left Content Start -->
          <div class="space-y-6">
            <h1
              class="text-4xl lg:text-5xl font-extrabold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-red-600">
              Rencanakan<br />
              Perjalanan Kamu 🚗
            </h1>

            <p class="text-slate-600 text-lg leading-relaxed max-w-md">
              Kelola semua tiket perjalananmu dan pastikan setiap destinasi
              berjalan sesuai rencana bersama
              <span class="font-semibold text-orange-600"
                >BellsHouse Travel</span
              >, tempat terbaik untuk merencanakan liburanmu.
            </p>
            <!-- left Content End -->

            <!-- Button Start -->
            <div class="gap-4 grid md:grid-cols-2 justify-items-start md:flex">
              <a
                href="home.php"
                class="px-7 py-3 rounded-2xl text-white text-lg font-medium bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 shadow-md hover:shadow-xl hover:scale-[1.04] transition-all duration-300">
                Tambah Pesanan
              </a>

              <a
                href="wishlist.php"
                class="px-7 py-3 rounded-2xl text-orange-600 text-lg font-medium border border-orange-500 bg-white hover:bg-orange-50 hover:scale-[1.04] transition-all duration-300">
                Check Wishlist
              </a>
            </div>
          </div>
          <!-- Button Start -->

          <!-- RIGHT: Wishlist Card Start -->
          <div
            class="p-8 rounded-3xl bg-orange-50 border border-orange-200 shadow-sm hover:shadow-md transition-all duration-300">
            <h2 class="text-sm text-slate-500 font-semibold tracking-wide">
              TOTAL PESANAN
            </h2>

            <p class="text-3xl font-bold text-orange-600 mt-1"><?= $total_pesanan ?> TRIP</p>

            <p class="text-sm text-slate-500 mt-3">
              Selalu Cek Status Sebelum
              <span class="text-orange-700 font-medium">Keberangkatan</span>
            </p>
          </div>
          <!-- RIGHT: Wishlist Card End -->
        </header>
      </section>
      <!-- Header Section End -->

      <!-- Card Section Start -->
      <section>
        <!-- Title Start -->
        <div class="mx-auto w-[92%] lg:w-[85%] max-w-7xl m-5">
          <h1 class="font-semibold text-2xl">Daftar Pesanan Kamu</h1>
        </div>
        <!-- Title End -->

        <!-- Card Container Start -->
        <div
          class="mx-auto w-[92%] lg:w-[85%] max-w-7xl grid md:grid-cols-2 xl:grid-cols-2 gap-5 justify-items-center">
          
          <?php if(empty($pesanan_list)): ?>
          <!-- Empty State -->
          <div class="col-span-full text-center py-16">
            <i class="fas fa-suitcase text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Yuk mulai rencanakan perjalanan impianmu!</p>
            <a href="home.php" class="px-6 py-3 rounded-xl text-white font-medium bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 hover:shadow-lg transition-all">
              <i class="fas fa-plus mr-2"></i>Buat Pesanan Baru
            </a>
          </div>
          <?php else: ?>
          
          <?php foreach($pesanan_list as $pesanan): ?>
          <?php 
            $durasi = hitungDurasi($pesanan['tanggal_keberangkatan'], $pesanan['tanggal_kepulangan']);
            
            // Status badge
            $status_class = '';
            $status_text = '';
            switch($pesanan['status']) {
                case 'pending':
                    $status_class = 'text-yellow-600';
                    $status_text = 'Pending';
                    break;
                case 'confirmed':
                    $status_class = 'text-blue-600';
                    $status_text = 'Confirmed';
                    break;
                case 'completed':
                    $status_class = 'text-green-600';
                    $status_text = 'Completed';
                    break;
                case 'cancelled':
                    $status_class = 'text-red-700';
                    $status_text = 'Cancelled';
                    break;
                default:
                    $status_class = 'text-gray-600';
                    $status_text = ucfirst($pesanan['status']);
            }
          ?>
          <div
            class="cursor-pointer bg-slate-100 rounded-2xl shadow-md overflow-hidden w-full max-w-2xl flex flex-col md:flex-row transition hover:shadow-lg hover:-translate-y-1 duration-300">
            <!-- Gambar -->
            <div class="md:w-1/2 w-full h-48 md:h-auto">
              <img
                src="../../backend/img/<?= htmlspecialchars($pesanan['foto']) ?>"
                alt="<?= htmlspecialchars($pesanan['nama_destinasi']) ?>"
                class="w-full h-full object-cover object-center" />
            </div>

            <!-- Detail -->
            <div
              class="md:w-1/2 w-full p-5 space-y-3 flex flex-col justify-between">
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <span
                    class="text-sm font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full">
                    <?= htmlspecialchars($pesanan['kategori']) ?>
                  </span>
                  <span class="text-sm font-semibold <?= $status_class ?>">
                    <?= $status_text ?>
                  </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900">
                  <?= htmlspecialchars($pesanan['nama_destinasi']) ?>
                </h3>
                <p class="text-slate-500 text-sm">
                  <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                  <?= htmlspecialchars($pesanan['provinsi']) ?>, <?= htmlspecialchars($pesanan['kota']) ?>
                </p>
                <p class="text-slate-500 text-sm">
                  💸 Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?>
                </p>
                <p class="text-slate-500 text-sm">⏳ Durasi: <?= $durasi ?> Hari</p>
                <p class="text-slate-500 text-sm">👥 <?= $pesanan['jumlah_orang'] ?> Orang</p>
                <p class="text-slate-500 text-sm">
                  🗓️ Berangkat: <?= date('d F Y', strtotime($pesanan['tanggal_keberangkatan'])) ?>
                </p>
              </div>

              <!-- Tombol -->
              <div class="text-right space-x-2">
                <button onclick="showDetail('<?= $pesanan['id'] ?>')"
                  class="px-4 py-2 text-sm font-semibold text-orange-600 border border-orange-500 rounded-md hover:bg-orange-50 transition-all duration-150">
                  <i class="fas fa-eye mr-1"></i>Detail
                </button>
                
                <?php if($pesanan['status'] === 'pending' || $pesanan['status'] === 'confirmed'): ?>
                <button onclick="if(confirm('Yakin ingin membatalkan pesanan ini?')) window.location.href='cancel-pesanan.php?id=<?= $pesanan['id'] ?>'"
                  class="px-4 py-2 text-sm font-semibold text-white rounded-md bg-gradient-to-r from-red-500 to-orange-500 hover:shadow-md transition-all duration-150">
                  <i class="fas fa-times mr-1"></i>Cancel
                </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          
          <?php endif; ?>
          
        </div>
        <!-- Card Container End -->
      </section>
      <!-- Card Section End -->
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php' ?>

    <!-- Modal Detail Pesanan -->
    <div id="detailModal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="bg-white  shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white rounded-t-2xl z-10">
                    <h3 class="text-2xl font-bold text-gray-800">Detail Pesanan</h3>
                    <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div id="detailContent" class="p-6">
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-orange-500"></i>
                        <p class="mt-2 text-gray-600">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
        function showDetail(idPesanan) {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            fetch('detail-pesanan.php?id=' + idPesanan)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('detailContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = 
                        '<div class="text-center text-red-600"><i class="fas fa-exclamation-circle text-4xl mb-2"></i><p>Error loading data</p></div>';
                });
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if(e.target === this) closeDetailModal();
        });
    </script>
    <script type="module" src="../../js/main.js"></script>
  </body>
</html>
