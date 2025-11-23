<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="font-[poppins] bg-gradient-to-b from-orange-50 to-white">

    <!-- Navbar -->
    <?php include '../components/navigation.php'?>

    <main class="py-16">
        <section>

            <!-- MAIN WRAPPER -->
            <div class="w-[90%] mx-auto grid md:grid-cols-2 gap-10 xl:gap-16 items-start">

                <!-- ========= LEFT : FORM ========= -->
                <div class="space-y-6">

                    <h1 class="text-3xl font-semibold text-slate-800">Detail Pememsanan</h1>
                    <p class="text-slate-600 max-w-md">
                        Lengkapi detailnya dengan datamu untuk pengiriman e-tiket dan keperluan pemesanan.
                    </p>

                    <!-- FORM START -->
                    <form action="" class="space-y-6">

                        <!-- Nama -->
                        <div>
                            <input 
                                type="text" 
                                class="w-full border-2 border-slate-300 rounded-xl p-5 text-lg text-black font-medium 
                                       focus:border-orange-500 outline-none placeholder:text-slate-400"
                                placeholder="Nama Lengkap Sesuai Identitas">
                        </div>

                        <!-- Gender -->
                        <div class="flex items-center gap-8">
                            <label class="flex items-center gap-3">
                                <input type="radio" name="sex">
                                <span>Laki-laki</span>
                            </label>

                            <label class="flex items-center gap-3">
                                <input type="radio" name="sex">
                                <span>Perempuan</span>
                            </label>
                        </div>

                        <!-- 2 Inputs -->
                        <div class="grid md:grid-cols-2 gap-5">
                            
                            <!-- Nomor -->
                            <div>
                                <input 
                                    type="tel" 
                                    placeholder="+62 xxx xxx xxx"
                                    class="w-full border border-slate-300 rounded-xl p-4 text-black text-lg 
                                           focus:border-orange-400 outline-none placeholder:text-slate-400 transition-all">
                            </div>

                            <!-- Jumlah Penumpang -->
                            <div>
                                <input 
                                    type="number" 
                                    placeholder="Jumlah Penumpang (max 2)"
                                    max="2"
                                    class="w-full border border-slate-300 rounded-xl p-4 text-black text-lg 
                                           focus:border-orange-400 outline-none placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <textarea 
                                class="w-full border border-slate-300 rounded-xl p-4 text-lg text-black 
                                       focus:border-orange-400 outline-none placeholder:text-slate-400 h-32 resize-none"
                                placeholder="Alamat"></textarea>
                        </div>

                    </form>
                    <!-- FORM END -->

                </div>

                <!-- ========== RIGHT : CARD + INFO ========== -->
                <div class="space-y-10">

                    <!-- Card (muncul di lg ke atas) -->
                    <a 
                        href="#" 
                        class="hidden lg:block max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 
                               group hover:shadow-xl hover:scale-[1.03] transition-all duration-200 mx-auto">

                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" 
                                 alt="Gunung Masamba" 
                                 class="w-full object-cover object-center h-52 
                                        group-hover:scale-105 duration-200 transition-all">
                        </header>

                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium">Gunung Masamba</h1>
                                <p class="whitespace-nowrap">
                                    <span class="font-bold">Rp.200.000</span> / Malam
                                </p>
                            </div>

                            <footer class="space-y-3 text-slate-700">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex gap-1.5 items-center">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                    </a>

                    <!-- Penerbangan Start-->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <header class="flex justify-between items-center mb-4">
                            <h1 class="font-semibold text-slate-700">Penerbangan 1</h1>
                            <p class="text-slate-500">Jum 28, Nov 2025</p>
                        </header>
                        
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium text-slate-700">Samarinda</p>
                                <p class="text-slate-500 text-sm">Kota Keberangkatan</p>
                            </div>
                            
                            <div>
                                <p class="font-medium text-slate-700">Balikpapan</p>
                                <p class="text-slate-500 text-sm">Kota Tujuan</p>
                            </div>
                        </div>
                    </div>
                    <!-- Penerbangan End-->

                   <!-- Order Start -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm 
                                grid gap-5 md:grid-cols-2 items-center">

                        <!-- Total Harga -->
                        <header class="space-y-1 md:text-left text-center">
                            <h1 class="font-semibold text-sm text-slate-700">Total Tiket</h1>
                            <p class="text-2xl font-semibold text-black">Rp.400.000</p>
                        </header>

                        <!-- Tombol -->
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-3 w-full">

                            <!-- Tombol Pesan -->
                            <button
                                type="submit"
                                class="px-7 py-3 rounded-2xl text-white text-lg font-medium 
                                    bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 
                                    shadow-md hover:shadow-xl hover:scale-[1.04] 
                                    transition-all duration-300 w-full cursor-pointer">
                                Pesan
                            </button>

                            <!-- Tombol Tambah Wishlist -->
                            <button
                                type="button"
                                class="px-4 py-3 rounded-2xl text-orange-600 text-lg font-medium 
                                    border border-orange-500 bg-white 
                                    hover:bg-orange-50 hover:scale-[1.04] 
                                    transition-all duration-300 w-full cursor-pointer">
                                Tambah Wishlist
                            </button>

                        </div>
                    </div>
                    <!-- Order End -->

                </div>

            </div>

        </section>
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php' ?>
    <!-- JS -->
     <script src="../../js/main.js" type="module"></script>
</body>
</html>
