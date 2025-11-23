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
    <link
        href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <!-- Font Custom CDN Start -->

    <!-- Font Awesome CDN Start -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Font Awesome CDN End -->
</head>

<body class="font-[poppins] bg-[#E7ECF2] overflow-x-hidden">
    <!-- Main Start -->
    <main>
        <!-- Hero Section Start -->
        <section
            class="bg-blend-multiply bg-[rgba(184,230,254)] bg-[url(../../assets/hero-bg.png)] xl:bg-no-repeat xl:bg-cover mb-105 sm:mb-65 md:mb-45 lg:mb-15 ">
            <!-- Hero Start -->
            <div>
                <!-- Header Hero Start -->
                <?php
                session_start();
                include '../../backend/connection.php';
                include '../components/navigation.php';
                ?>
                <!-- Header Hero End -->

                <!-- Content Hero Start -->
                <div class="py-30 px-5 relative">
                    <h1 class="text-4xl text-center font-extrabold font-[inter] text-white mb-5">Explore The West Borneo
                    </h1>

                    <!-- Flight Search Section Start -->
                    <div
                        class="rounded-3xl bg-white p-5 space-y-3 absolute shadow-lg w-[90%] left-1/2 -translate-x-1/2 lg:bg-transparent lg:p-0 lg:static lg:shadow-none lg:w-auto lg:space-y-0 lg:-translate-x-0  ">
                        <!-- G-1 Srart -->
                        <div
                            class="grid gap-3 sm:grid-cols-2 lg:bg-white lg:rounded-[36px] lg:p-5 lg:rounded-br-none lg:w-[90%] lg:max-w-6xl lg:mx-auto  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                            <!-- Select Form Start -->
                            <div>
                                <select id="filter-kategori" onchange="applyFilters()"
                                    class="w-full border-2 border-slate-300 rounded-3xl p-5 text-slate-500 font-medium focus:border-red-500 outline-none">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    $query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
                                    while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                                        ?>
                                        <option value="<?= $kategori['id'] ?>"><?= $kategori['kategori'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- Select Form End -->

                            <!-- Search Form Start -->
                            <div class="relative lg:flex lg:items-center gap-3">
                                <input type="text" id="search-input"
                                    class="w-full border-2 border-slate-300 rounded-3xl p-5 text-black font-medium focus:border-red-500 outline-none placeholder:text-slate-400"
                                    placeholder="Cari Tempat Wisata"
                                    oninput="handleSearch(this.value)"
                                    onfocus="showSearchResults()"
                                    autocomplete="off">
                                <button type="button" onclick="handleSearch(document.getElementById('search-input').value)"
                                    class="absolute rounded-full bg-red-600 text-slate-200 px-4 py-3 hover:bg-red-700 transition-all duration-150 cursor-pointer -translate-x-15 top-1/2 -translate-y-1/2 lg:static lg:-translate-y-0 lg:-translate-x-0">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                                
                                <!-- Search Results Layer -->
                                <div id="search-results" 
                                    class="hidden absolute top-full left-0 right-0 mt-3 bg-white rounded-2xl shadow-2xl max-h-96 overflow-y-auto z-50 border-2 border-slate-200">
                                    <div id="search-results-content" class="p-4">
                                        <!-- Results will be inserted here -->
                                    </div>
                                </div>
                            </div>
                            <!-- Search Form End -->
                        </div>
                        <!-- G-1 End -->

                        <!-- G-2 Start -->
                        <div
                            class="space-y-3 lg:space-y-0 md:grid lg:grid-cols-2 lg:items-center lg:mx-auto lg:w-[90%] lg:max-w-6xl relative z-10 ">
                            <!-- SG-1 Start -->
                            <div class="grid gap-5 sm:grid-cols-2 lg:p-5 relative">
                                <svg class="pointer-events-none absolute -top-1 right-0 h-11 w-11" viewBox="0 0 44 44"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0,0 Q44,0 44,44 L44,0 Z" fill="white" fill-opacity="1"></path>
                                </svg>
                                <a href="mytrip.php"
                                    class="font-bold gap-5 text-xl text-slate-100 p-5 flex justify-center items-center rounded-full bg-linear-to-r/oklch from-red-600 via-orange-400 to-amber-300 hover:scale-105 duration-300 transition-all md:px-5 py-4  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                    <i class="fa-solid fa-plane-departure"></i>
                                    My Trip
                                </a>
                                <a href="wishlist.php"
                                    class="font-bold gap-5 text-xl text-slate-100 p-5 flex justify-center items-center rounded-full bg-linear-to-r/oklch from-red-600 via-orange-400 to-amber-300 hover:scale-105 duration-300 transition-all md:px-5 py-4  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                    <i class="fa-regular fa-heart"></i>
                                    Wishlist
                                </a>
                            </div>
                            <!-- SG-1 End -->

                            <!-- SG-2 Start -->
                            <div
                                class="grid gap-3 md:grid-cols-2  lg:bg-white lg:p-3 lg:rounded-b-[36px]  lg:ring-5 lg:ring-slate-50/25 lg:shadow-md lg:shadow-slate-100/50">
                                <div class="lg:py-2">
                                    <select id="filter-provinsi" onchange="applyFilters()"
                                        class="w-full border-2 border-slate-300 rounded-full p-5 text-slate-500 font-medium focus:border-orange-400 outline-none">
                                        <option value="">Semua Provinsi</option>
                                        <?php
                                        $query_provinsi = mysqli_query($conn, "SELECT DISTINCT provinsi.id, provinsi.provinsi FROM provinsi 
                                                                              JOIN kota ON provinsi.id = kota.id_provinsi 
                                                                              JOIN destinasi ON kota.id = destinasi.id_kota 
                                                                              ORDER BY provinsi.provinsi");
                                        while ($prov = mysqli_fetch_assoc($query_provinsi)) {
                                            ?>
                                            <option value="<?= $prov['id'] ?>"><?= $prov['provinsi'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="lg:py-2">
                                    <select id="filter-kota" onchange="applyFilters()"
                                        class="w-full border-2 border-slate-300 rounded-full p-5 text-slate-500 font-medium focus:border-orange-400 outline-none">
                                        <option value="">Semua Kota</option>
                                        <?php
                                        $query_kota = mysqli_query($conn, "SELECT DISTINCT kota.id, kota.kota FROM kota 
                                                                          JOIN destinasi ON kota.id = destinasi.id_kota 
                                                                          ORDER BY kota.kota");
                                        while ($kot = mysqli_fetch_assoc($query_kota)) {
                                            ?>
                                            <option value="<?= $kot['id'] ?>"><?= $kot['kota'] ?></option>
                                        <?php } ?>
                                    </select>
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
                    <?php
                    // Get user wishlist IDs
                    $wishlist_ids = [];
                    if(isset($_SESSION['user_id'])){
                        $user_id = $_SESSION['user_id'];
                        $wishlist_query = mysqli_query($conn, "SELECT id_destinasi FROM wishlist WHERE id_user = '$user_id'");
                        while($w = mysqli_fetch_assoc($wishlist_query)){
                            $wishlist_ids[] = $w['id_destinasi'];
                        }
                    }
                    
                    $query_destinasi = mysqli_query($conn, "SELECT destinasi.*, kota.kota, kota.id as id_kota_val, provinsi.provinsi, provinsi.id as id_provinsi_val, kategori.id as id_kategori_val
                                                          FROM destinasi 
                                                          JOIN kota ON destinasi.id_kota = kota.id 
                                                          JOIN provinsi ON kota.id_provinsi = provinsi.id
                                                          JOIN kategori ON destinasi.id_kategori = kategori.id");
                    while ($row = mysqli_fetch_assoc($query_destinasi)) {
                        $in_wishlist = in_array($row['id'], $wishlist_ids);
                        ?>
                        <div class="w-full rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150 relative destination-card"
                             data-kategori="<?= $row['id_kategori_val'] ?>"
                             data-provinsi="<?= $row['id_provinsi_val'] ?>"
                             data-kota="<?= $row['id_kota_val'] ?>"
                             data-nama="<?= strtolower($row['nama_destinasi']) ?>">
                            <a href="detail-destinasi.php?id=<?= $row['id'] ?>">
                                <header class="relative">
                                    <img src="../../backend/img/<?= $row['foto'] ?>" alt="<?= $row['nama_destinasi'] ?>"
                                        class="w-full object-cover object-center h-48 group-hover:scale-105 duration-200 transition-all">
                                </header>
                                <div class="p-4 space-y-3">
                                    <h1 class="text-lg font-medium line-clamp-1"><?= $row['nama_destinasi'] ?></h1>
                                    <p class="text-sm">
                                        <span class="font-bold text-orange-600">Rp.<?= number_format($row['harga'], 0, ',', '.') ?></span>
                                        <span class="text-slate-500"> / Malam</span>
                                    </p>
                                    <div class="flex items-center gap-1.5 text-sm text-slate-600">
                                        <i class="fa-solid fa-location-dot text-red-500"></i>
                                        <p class="line-clamp-1"><?= $row['provinsi'] ?>, <?= $row['kota'] ?></p>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Wishlist Button -->
                            <?php if(isset($_SESSION['user_id'])): ?>
                            <button onclick="toggleWishlist('<?= $row['id'] ?>', this, event)" 
                                    class="absolute top-5 right-5 z-10 w-10 h-10 rounded-full bg-white/90 hover:bg-white shadow-md flex items-center justify-center transition-all duration-200 hover:scale-110"
                                    data-in-wishlist="<?= $in_wishlist ? 'true' : 'false' ?>">
                                <i class="<?= $in_wishlist ? 'fa-solid' : 'fa-regular' ?> fa-heart text-red-500 text-xl"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
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
    <script>
        // All destinations data
        const allDestinations = [
            <?php
            mysqli_data_seek($query_destinasi, 0); // Reset pointer
            $destinations = [];
            while ($row = mysqli_fetch_assoc($query_destinasi)) {
                $destinations[] = json_encode([
                    'id' => $row['id'],
                    'nama' => $row['nama_destinasi'],
                    'harga' => $row['harga'],
                    'foto' => $row['foto'],
                    'provinsi' => $row['provinsi'],
                    'kota' => $row['kota']
                ]);
            }
            echo implode(',', $destinations);
            ?>
        ];

        let searchTimeout;
        
        function handleSearch(query) {
            clearTimeout(searchTimeout);
            
            if(query.trim().length === 0) {
                hideSearchResults();
                return;
            }
            
            searchTimeout = setTimeout(() => {
                const results = searchDestinations(query);
                displaySearchResults(results, query);
            }, 300);
        }
        
        function searchDestinations(query) {
            const searchTerm = query.toLowerCase();
            return allDestinations.filter(dest => 
                dest.nama.toLowerCase().includes(searchTerm) ||
                dest.kota.toLowerCase().includes(searchTerm) ||
                dest.provinsi.toLowerCase().includes(searchTerm)
            ).slice(0, 5); // Limit to 5 results
        }
        
        function displaySearchResults(results, query) {
            const container = document.getElementById('search-results-content');
            const resultsDiv = document.getElementById('search-results');
            
            if(results.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-6 text-slate-500">
                        <i class="fa-solid fa-search text-3xl mb-2 block"></i>
                        <p class="font-medium">Tidak ada hasil untuk "${query}"</p>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="mb-3 pb-2 border-b border-slate-200">
                        <p class="text-sm font-semibold text-slate-600">Ditemukan ${results.length} destinasi</p>
                    </div>
                    <div class="space-y-2">
                        ${results.map(dest => `
                            <a href="detail-destinasi.php?id=${dest.id}" 
                               class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-xl transition-all duration-200 group">
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-slate-200">
                                    <img src="../../backend/img/${dest.foto}" 
                                         alt="${dest.nama}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-orange-600 transition-colors">
                                        ${dest.nama}
                                    </h3>
                                    <p class="text-sm text-slate-500 flex items-center gap-1 mt-1">
                                        <i class="fa-solid fa-location-dot text-red-500 text-xs"></i>
                                        ${dest.kota}, ${dest.provinsi}
                                    </p>
                                    <p class="text-sm font-bold text-orange-600 mt-1">
                                        Rp ${Number(dest.harga).toLocaleString('id-ID')} / Malam
                                    </p>
                                </div>
                                <i class="fa-solid fa-chevron-right text-slate-400 group-hover:text-orange-600 transition-colors"></i>
                            </a>
                        `).join('')}
                    </div>
                `;
            }
            
            resultsDiv.classList.remove('hidden');
        }
        
        function showSearchResults() {
            const input = document.getElementById('search-input');
            if(input.value.trim().length > 0) {
                document.getElementById('search-results').classList.remove('hidden');
            }
        }
        
        function hideSearchResults() {
            document.getElementById('search-results').classList.add('hidden');
        }
        
        // Close search results when clicking outside
        document.addEventListener('click', function(event) {
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                hideSearchResults();
            }
        });
        
        function toggleWishlist(idDestinasi, button, event) {
            event.preventDefault();
            event.stopPropagation();
            
            const icon = button.querySelector('i');
            const inWishlist = button.getAttribute('data-in-wishlist') === 'true';
            const action = inWishlist ? 'remove' : 'add';
            
            // Disable button
            button.disabled = true;
            
            fetch('../../backend/wishlist-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_destinasi=${idDestinasi}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    if(data.action === 'added') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        button.setAttribute('data-in-wishlist', 'true');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        button.setAttribute('data-in-wishlist', 'false');
                    }
                    
                    // Show toast notification
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
                button.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
                button.disabled = false;
            });
        }
        
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-5 z-[100] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all transform translate-x-0 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }
        
        // Filter functionality
        function applyFilters() {
            const kategori = document.getElementById('filter-kategori').value;
            const provinsi = document.getElementById('filter-provinsi').value;
            const kota = document.getElementById('filter-kota').value;
            
            const cards = document.querySelectorAll('.destination-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const cardKategori = card.getAttribute('data-kategori');
                const cardProvinsi = card.getAttribute('data-provinsi');
                const cardKota = card.getAttribute('data-kota');
                
                const matchKategori = !kategori || cardKategori === kategori;
                const matchProvinsi = !provinsi || cardProvinsi === provinsi;
                const matchKota = !kota || cardKota === kota;
                
                if (matchKategori && matchProvinsi && matchKota) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show empty state if no results
            showEmptyState(visibleCount === 0);
        }
        
        function showEmptyState(show) {
            let emptyState = document.getElementById('empty-state');
            
            if (show && !emptyState) {
                const container = document.querySelector('.grid.gap-5.justify-center');
                emptyState = document.createElement('div');
                emptyState.id = 'empty-state';
                emptyState.className = 'col-span-full text-center py-12';
                emptyState.innerHTML = `
                    <div class="bg-white rounded-2xl p-8 shadow-md max-w-md mx-auto">
                        <i class="fa-solid fa-search text-6xl text-slate-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak Ada Hasil</h3>
                        <p class="text-slate-500 mb-4">Tidak ada destinasi yang sesuai dengan filter Anda</p>
                        <button onclick="resetFilters()" class="px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-all">
                            <i class="fa-solid fa-rotate-right mr-2"></i>Reset Filter
                        </button>
                    </div>
                `;
                container.appendChild(emptyState);
            } else if (!show && emptyState) {
                emptyState.remove();
            }
        }
        
        function resetFilters() {
            document.getElementById('filter-kategori').value = '';
            document.getElementById('filter-provinsi').value = '';
            document.getElementById('filter-kota').value = '';
            applyFilters();
        }
    </script>
    <script src="../../js/main.js" type="module"></script>
</body>

</html>