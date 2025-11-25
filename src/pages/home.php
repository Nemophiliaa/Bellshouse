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
    
    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .chat-message {
            animation: slideUp 0.3s ease-out;
        }
        .typing-indicator span {
            animation: blink 1.4s infinite;
        }
        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes blink {
            0%, 60%, 100% { opacity: 0.3; }
            30% { opacity: 1; }
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
    </style>
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

    <!-- AI Chat Assistant Start -->
    <div id="ai-chat-widget" class="fixed bottom-6 right-6 z-[90]">
        <!-- Chat Button -->
        <button id="chat-toggle-btn" 
                class="relative w-16 h-16 rounded-full bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 text-white shadow-2xl hover:shadow-3xl hover:scale-110 transition-all duration-300 flex items-center justify-center group">
            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 opacity-75 pulse-ring"></div>
            <i class="fas fa-robot text-2xl relative z-10 group-hover:animate-bounce"></i>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
        </button>

        <!-- Chat Window -->
        <div id="chat-window" 
             class="hidden absolute bottom-20 right-0 w-96 max-w-[calc(100vw-3rem)] h-[600px] max-h-[80vh] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-200">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-robot text-orange-500 text-xl"></i>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-white flex items-center gap-2">
                            BellsBot AI
                            <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full">Gemini</span>
                        </h3>
                        <p class="text-xs text-orange-100">🤖 Online • Powered by AI</p>
                    </div>
                </div>
                <button id="chat-close-btn" class="text-white hover:bg-white/20 w-8 h-8 rounded-full transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Messages Container -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gradient-to-b from-gray-50 to-white">
                <!-- Welcome Message -->
                <div class="chat-message flex gap-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-800">👋 <strong>Halo! Selamat datang di BellsBot AI!</strong></p>
                            <p class="text-sm text-gray-700 mt-2">Saya adalah asisten virtual bertenaga AI yang siap membantu Anda menemukan destinasi wisata terbaik di <strong>Kalimantan Barat</strong>. ✨</p>
                            <p class="text-sm text-gray-600 mt-2">💬 Tanyakan apa saja tentang wisata Kalbar!</p>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <button onclick="sendQuickMessage('Halo BellsBot!')" class="text-xs bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 px-3 py-1.5 rounded-full hover:from-orange-200 hover:to-red-200 transition-all font-medium shadow-sm">
                                👋 Sapaan
                            </button>
                            <button onclick="sendQuickMessage('Rekomendasi wisata pantai')" class="text-xs bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 px-3 py-1.5 rounded-full hover:from-blue-200 hover:to-cyan-200 transition-all font-medium shadow-sm">
                                🏖️ Wisata Pantai
                            </button>
                            <button onclick="sendQuickMessage('Tempat wisata murah di Kalbar')" class="text-xs bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 px-3 py-1.5 rounded-full hover:from-green-200 hover:to-emerald-200 transition-all font-medium shadow-sm">
                                💰 Budget Friendly
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form id="chat-form" class="flex gap-2">
                    <input type="text" 
                           id="chat-input" 
                           placeholder="Tanya tentang wisata Kalbar..." 
                           class="flex-1 px-4 py-2.5 border border-gray-300 rounded-full focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 text-sm transition-all"
                           autocomplete="off">
                    <button type="submit" 
                            id="send-btn"
                            class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full hover:shadow-lg transition-all flex items-center justify-center hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <p class="text-xs text-gray-500 text-center mt-2">
                    <i class="fas fa-shield-alt mr-1"></i>Powered by Google Gemini AI
                </p>
            </div>
        </div>
    </div>
    <!-- AI Chat Assistant End -->

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
        
        // Make handleSearch global
        window.handleSearch = function handleSearch(query) {
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
        
        window.showSearchResults = function showSearchResults() {
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
        
        window.toggleWishlist = function toggleWishlist(idDestinasi, button, event) {
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
        window.applyFilters = function applyFilters() {
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
        
        window.resetFilters = function resetFilters() {
            document.getElementById('filter-kategori').value = '';
            document.getElementById('filter-provinsi').value = '';
            document.getElementById('filter-kota').value = '';
            applyFilters();
        }
        
        // ============ AI CHAT FUNCTIONALITY WITH GEMINI ============
        const chatToggleBtn = document.getElementById('chat-toggle-btn');
        const chatWindow = document.getElementById('chat-window');
        const chatCloseBtn = document.getElementById('chat-close-btn');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const sendBtn = document.getElementById('send-btn');
        
        // Toggle chat window
        chatToggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            if(!chatWindow.classList.contains('hidden')){
                chatInput.focus();
                scrollToBottom();
            }
        });
        
        chatCloseBtn.addEventListener('click', () => {
            chatWindow.classList.add('hidden');
        });

        // Helper to scroll to bottom
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Quick message handler
        window.sendQuickMessage = function(text) {
            chatInput.value = text;
            chatForm.dispatchEvent(new Event('submit'));
        }

        // Typing indicator helpers
        function showTypingIndicator() {
            const div = document.createElement('div');
            div.id = 'typing-indicator';
            div.className = 'chat-message flex gap-3';
            div.innerHTML = `
                <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 typing-indicator flex gap-1">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                </div>
            `;
            chatMessages.appendChild(div);
            scrollToBottom();
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if(indicator) indicator.remove();
        }

        function getCurrentTime() {
            return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Extract destination cards from AI response
        function extractDestinationCards(aiText) {
            const cards = [];
            const regex = /\[DEST:([A-Z0-9]+)\]/gi;
            const matches = aiText.matchAll(regex);
            
            for (const match of matches) {
                const destId = match[1];
                // Note: allDestinations is defined above in the PHP loop
                const dest = allDestinations.find(d => d.id == destId);
                if (dest && !cards.find(c => c.id == dest.id)) {
                    cards.push(dest);
                }
            }
            
            return cards.slice(0, 4); // Limit to 4 cards
        }
        
        // Generate smart suggestions
        function generateSuggestions(message, hasCards) {
            const messageLower = message.toLowerCase();
            
            if (messageLower.includes('halo') || messageLower.includes('hai')) {
                return ['Wisata populer', 'Rekomendasi budget', 'Pantai terdekat', 'Wisata kuliner'];
            } else if (messageLower.includes('pantai')) {
                return ['Pantai lainnya', 'Wisata air', 'Resort tepi pantai', 'Destinasi kuliner'];
            } else if (messageLower.includes('gunung') || messageLower.includes('hiking')) {
                return ['Gunung lainnya', 'Tips hiking', 'Tempat camping', 'Wisata alam'];
            } else if (messageLower.includes('murah') || messageLower.includes('budget')) {
                return ['Paket hemat', 'Wisata gratis', 'Tips hemat', 'Promo spesial'];
            } else if (hasCards) {
                return ['Detail lebih lanjut', 'Tempat serupa', 'Cara booking', 'Tips berkunjung'];
            } else {
                return ['Rekomendasi wisata', 'Destinasi populer', 'Wisata murah', 'Bantuan'];
            }
        }
        
        // Send message
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if(!message) return;
            

            
            // Disable input
            chatInput.disabled = true;
            sendBtn.disabled = true;
            
            // Add user message
            addMessage(message, 'user');
            chatInput.value = '';
            
            // Show typing indicator
            showTypingIndicator();
            
            try {

                const startTime = performance.now();
                
                // Call Backend Handler
                const response = await fetch('../../backend/ai-chat-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                const endTime = performance.now();

                
                // Remove typing indicator
                removeTypingIndicator();

                if (data.error) {
                    throw new Error(data.error);
                }

                const aiText = data.text;

                
                // Extract destination cards from response
                const destinasiCards = extractDestinationCards(aiText);

                
                // Remove [DEST:ID] tags from text
                const cleanText = aiText.replace(/\[DEST:[A-Z0-9]+\]/gi, '');
                
                // Generate suggestions
                const suggestions = generateSuggestions(message, destinasiCards.length > 0);
                
                // Add bot message
                addMessage(cleanText, 'bot', suggestions, destinasiCards);
                
            } catch(error) {
                console.error('❌ Chat Error:', error);
                removeTypingIndicator();
                
                let errorMessage = '❌ Maaf, terjadi kesalahan saat menghubungi AI.\n\n';
                errorMessage += '⚠️ Error: ' + error.message + '\n';
                
                errorMessage += '\n💡 Sementara itu, Anda bisa:\n';
                errorMessage += '• Gunakan filter pencarian di atas\n';
                errorMessage += '• Lihat katalog destinasi\n';
                errorMessage += '• Coba lagi dalam beberapa saat';
                
                addMessage(errorMessage, 'bot', ['Coba lagi', 'Lihat destinasi', 'Bantuan']);
                
            } finally {
                // Enable input
                chatInput.disabled = false;
                sendBtn.disabled = false;
                chatInput.focus();
                scrollToBottom();
            }
        });
        
        function addMessage(text, sender, suggestions = [], destinasiCards = []) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message flex gap-3';
            
            if(sender === 'user') {
                messageDiv.innerHTML = `
                    <div class="flex-1"></div>
                    <div class="max-w-[80%]">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-3 rounded-2xl rounded-tr-none shadow-md">
                            <p class="text-sm">${escapeHtml(text)}</p>
                        </div>
                        <p class="text-xs text-gray-400 text-right mt-1">${getCurrentTime()}</p>
                    </div>
                `;
            } else {
                // Format bot message with markdown-like support
                let formattedText = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n/g, '<br>');
                
                let cardsHTML = '';
                if(destinasiCards.length > 0) {
                    cardsHTML = '<div class="mt-3 space-y-2">';
                    destinasiCards.forEach(dest => {
                        cardsHTML += `
                            <a href="detail-destinasi.php?id=${dest.id}" target="_blank" 
                               class="block bg-gradient-to-r from-white to-gray-50 border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all group">
                                <div class="flex gap-3 p-2">
                                    <img src="../../backend/img/${dest.foto}" 
                                         alt="${escapeHtml(dest.nama)}" 
                                         class="w-24 h-24 object-cover rounded-lg flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-sm text-gray-800 line-clamp-1 group-hover:text-orange-600 transition-colors">${escapeHtml(dest.nama)}</h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-map-marker-alt text-red-500"></i> ${escapeHtml(dest.kota)}, ${escapeHtml(dest.provinsi)}
                                        </p>
                                        <p class="text-sm font-bold text-orange-600 mt-1">
                                            💰 Rp ${Number(dest.harga).toLocaleString('id-ID')}
                                        </p>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-slate-300 self-center group-hover:text-orange-500"></i>
                                </div>
                            </a>
                        `;
                    });
                    cardsHTML += '</div>';
                }
                
                let suggestionsHTML = '';
                if(suggestions.length > 0) {
                    suggestionsHTML = '<div class="flex flex-wrap gap-2 mt-2">';
                    suggestions.forEach(sugg => {
                        suggestionsHTML += `
                            <button onclick="sendQuickMessage('${sugg}')" class="text-xs bg-gradient-to-r from-orange-50 to-red-50 text-orange-700 px-3 py-1.5 rounded-full hover:from-orange-100 hover:to-red-100 transition-all font-medium shadow-sm border border-orange-100">
                                ${sugg}
                            </button>
                        `;
                    });
                    suggestionsHTML += '</div>';
                }

                messageDiv.innerHTML = `
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-800">${formattedText}</p>
                        </div>
                        ${cardsHTML}
                        ${suggestionsHTML}
                        <p class="text-xs text-gray-400 mt-1">${getCurrentTime()}</p>
                    </div>
                `;
            }
            
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }
    </script>
    <script src="../../js/main.js" type="module"></script>
</body>

</html>