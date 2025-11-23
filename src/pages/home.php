<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Tailwind CDN Start -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Tailwind CDN End -->

    <!-- Font Custom CDN Start-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- Font Custom CDN Start -->

    <!-- Font Awesome CDN Start -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Awesome CDN End -->
</head>
<body class="font-[poppins] bg-[#E7ECF2] overflow-x-hidden">
    <!-- Main Start -->
    <main>
        <!-- Hero Section Start -->
        <section class="bg-blend-multiply bg-[rgba(184,230,254)] bg-[url(../../assets/hero-bg.png)] xl:bg-no-repeat xl:bg-cover mb-105 sm:mb-65 md:mb-45 lg:mb-15 ">
            <!-- Hero Start -->
            <div>
                <!-- Header Hero Start -->
                 <?php include '../components/navigation.php'?>
                <!-- Header Hero End -->

                <!-- Content Hero Start -->
                <div class="py-30 px-5 relative">
                   <h1 class="text-4xl text-center font-extrabold font-[inter] text-white mb-5">Explore The West Borneo</h1>

                    <!-- Flight Search Section Start -->
                    <div class="rounded-3xl bg-white p-5 space-y-3 absolute shadow-lg w-[90%] left-1/2 -translate-x-1/2 lg:bg-transparent lg:p-0 lg:static lg:shadow-none lg:w-auto lg:space-y-0 lg:-translate-x-0  ">
                        <!-- G-1 Srart -->
                         <div class="grid gap-3 sm:grid-cols-2 lg:bg-white lg:rounded-[36px] lg:p-5 lg:rounded-br-none lg:w-[90%] lg:max-w-6xl lg:mx-auto  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                            <!-- Select Form Start -->
                            <div>
                                <select class="w-full border-2 border-slate-300 rounded-3xl p-5 text-slate-500 font-medium focus:border-red-500 outline-none">
                                    <option>Pilih Kategori Wisata</option>
                                    <option value="pantai">Pantai</option>
                                    <option value="gunung">Gunung</option>
                                    <option value="air terjun">Air Terjun</option>
                                    <option value="budaya">Budaya</option>
                                </select>
                            </div>
                            <!-- Select Form End -->

                            <!-- Search Form Start -->
                            <div class="relative lg:flex lg:items-center gap-3 ">
                                <input type="text" class="w-full border-2 border-slate-300 rounded-3xl p-5 text-black font-medium focus:border-red-500 outline-none placeholder:text-slate-400" placeholder="Cari Tempat Wisata">
                                <button type="button" class="absolute  rounded-full bg-red-600 text-slate-200 px-4 py-3 hover:bg-red-700 transition-all duration-150 cursor-pointer -translate-x-15 top-1/2 -translate-y-1/2 lg:static lg:-translate-y-0 lg:-translate-x-0"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <!-- Search Form End -->
                         </div>
                        <!-- G-1 End -->

                        <!-- G-2 Start -->
                        <div class="space-y-3 lg:space-y-0 md:grid lg:grid-cols-2 lg:items-center lg:mx-auto lg:w-[90%] lg:max-w-6xl relative z-10 ">
                            <!-- SG-1 Start -->
                            <div class="grid gap-5 sm:grid-cols-2 lg:p-5 relative">
                                <svg class="pointer-events-none absolute -top-1 right-0 h-11 w-11" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0,0 Q44,0 44,44 L44,0 Z" fill="white" fill-opacity="1"></path>
                                </svg>
                                <a href="mytrip.php" class="font-bold gap-5 text-xl text-slate-100 p-5 flex justify-center items-center rounded-full bg-linear-to-r/oklch from-red-600 via-orange-400 to-amber-300 hover:scale-105 duration-300 transition-all md:px-5 py-4  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                    <i class="fa-solid fa-plane-departure"></i>
                                    My Trip
                                </a>
                                <a href="wishlist.php" class="font-bold gap-5 text-xl text-slate-100 p-5 flex justify-center items-center rounded-full bg-linear-to-r/oklch from-red-600 via-orange-400 to-amber-300 hover:scale-105 duration-300 transition-all md:px-5 py-4  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                    <i class="fa-regular fa-heart"></i>
                                    Wishlist
                                </a>
                            </div>
                            <!-- SG-1 End -->
                            
                            <!-- SG-2 Start -->
                            <div class="grid gap-3 md:grid-cols-2  lg:bg-white lg:p-3 lg:rounded-b-[36px]  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                <div class="relative lg:py-2">
                                    <input type="date" class="w-full border-2 appearance-none border-slate-300 rounded-full p-5 text-black font-medium focus:border-orange-400 outline-none">
                                    <span class="text-slate-500 absolute -translate-y-1/2 top-1/2 whitespace-nowrap  text-xs sm:text-sm left-1/2 md:-translate-x-5
                                     lg:-translate-y-15 lg:-translate-x-25">Tanggal Berangkat</span>
                                </div>
                                <div class="relative lg:py-2">
                                    <input  type="date" class="w-full border-2 appearance-none border-slate-300 rounded-full p-5 text-black font-medium focus:border-orange-400 outline-none">
                                    <span class="text-slate-500 absolute -translate-y-1/2 top-1/2 whitespace-nowrap  text-xs sm:text-sm left-1/2 lg:-translate-y-15 lg:-translate-x-25">Tanggal Pergi</span>
                                </div>
                            </div>
                            <!-- SG-2 End -->
                        </div>
                        <!-- G-2 Start -->
                    </div>
                    <!-- Flight Search Section End -->
                </div>
                <!-- Content Hero End -->
            </div>
            <!-- Hero Start -->
        </section>
        <!-- Hero Section End -->

        <!-- Content Card Section Start  -->
         <section>
            <!-- Content Start -->
            <div class="mx-auto w-[90%] max-w-6xl">
                <h1 class="text-2xl font-bold text-[#0A2646] mb-5.5">Cari Pesona Kalimantan Barat</h1>
                
                <!-- Card Container Start -->
                <div class="grid gap-5  justify-center sm:justify-normal sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <!-- Card Start -->
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <!-- Misal Udah Ditambah Ke Wishlist -->
                            <i class="fa-solid fa-heart text-red-500 absolute right-0 top-5 -translate-x-5 text-xl"></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>
                     
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <i></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>

                     <!-- Nanti Dihapus (Placeholder) -->
                     
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <i></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>
                     
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <i></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>
                     
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <i></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>
                     
                     <a href="pemesanan.php" class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
                        <header class="relative">
                            <img src="../../assets/gunungMasamba.png" alt="Gunung Masamba" class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all">
                            <i></i>
                        </header>
                        <div class="p-5 space-y-5">
                            <div class="flex justify-between items-center gap-1.5">
                                <h1 class="text-xl font-medium ">Gunung Masamba </h1>
                                <p class="whitespace-nowrap sm:whitespace-normal"><span class="font-bold"> Rp.200.000 </span>/ Malam</p>
                            </div>
                            <footer class="space-y-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                                    <p>Kalimantan Timur, Samarinda</p>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <div class="flex gap-1.5">
                                        <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                                        <p class="text-slate-500">4.9</p>
                                    </div>
                                    <p class="text-slate-500">89 Reviews</p>
                                </div>
                            </footer>
                        </div>
                     </a>
                    <!-- Card End -->
                </div>
                <!-- Card Container End -->
            </div>
            <!-- Content End -->
         </section>
        <!-- Content Card Section End  -->
    </main>
    <!-- Main End -->

    <!-- Footer Start -->
    <?php include '../components/footer.php' ?>
    <!-- Footer Start -->

    <!-- JS -->
    <script src="../../js/main.js" type="module"></script>
</body>
</html>