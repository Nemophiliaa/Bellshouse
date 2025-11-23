<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
<body class="font-[poppins]">
    <!-- Main Start -->
    <main class="relative min-h-screen overflow-hidden">
    <!-- Video Background  Start -->
    <video 
        src="../../assets/video-bg.mp4" 
        autoplay 
        loop 
        muted 
        playsinline
        class="absolute inset-0 w-full h-full object-cover z-0">
    </video>
    <!-- Video Background  End -->

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm z-0"></div>

    <section class="relative z-10 flex justify-center items-center min-h-screen p-5">
        <!-- Form Card Start -->
        <div class="w-full max-w-xl p-10 rounded-3xl bg-white/10 backdrop-blur-xl 
                    shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-white/30">

            <!-- Title Start -->
            <h1 class="text-center font-[inter] font-bold text-4xl mb-2 text-white drop-shadow-lg">
                Masuk BellsHouse Travel
            </h1>
            
            <p class="text-center text-slate-200 mb-8 drop-shadow">
                Nikmati pengalaman menyenangkan hanya di 
                <span class="font-semibold bg-linear-to-r/oklch from-orange-500 to-red-500 bg-clip-text text-transparent">
                    BellsHouse.
                </span>
            </p>
            <!-- Title End -->

            <!-- Form  Start -->
            <form action="">
                <!-- Username -->
                <div class="mb-5">
                    <label class="block font-medium text-white text-lg mb-2 drop-shadow">Nama Lengkap :</label>
                    <input 
                    type="text" 
                    placeholder="Nama Kamu"
                    class="w-full border border-white/40 rounded-xl p-4 text-black text-lg 
                    focus:border-orange-400 outline-none bg-white/70 hover:bg-white/90 
                    transition-all">
                </div>

                <!-- Email & No Tlp -->
                <div class="grid md:grid-cols-2 gap-5 mb-5">     
                    <div>
                        <label class="block font-medium text-white text-lg mb-2 drop-shadow">Email :</label>
                        <input 
                        type="email" 
                        placeholder="email@gmail.com"
                        class="w-full border border-white/40 rounded-xl p-4 text-black text-lg 
                        focus:border-orange-400 outline-none bg-white/70 hover:bg-white/90 
                        transition-all">
                    </div>

                    <div>
                        <label class="block font-medium text-white text-lg mb-2 drop-shadow">No Telepon :</label>
                        <input 
                        type="tel" 
                        placeholder="+62 xxx xxx xxx"
                        class="w-full border border-white/40 rounded-xl p-4 text-black text-lg 
                        focus:border-orange-400 outline-none bg-white/70 hover:bg-white/90 
                        transition-all">
                    </div>
                </div>
                
                <!-- Password -->
                <div class="grid md:grid-cols-2 gap-5 ">
                    <div>
                        <label class="block font-medium text-white text-lg mb-2 drop-shadow">Password :</label>
                        <input 
                        type="password"
                        class="w-full border border-white/40 rounded-xl p-4 text-black text-lg 
                        focus:border-orange-400 outline-none bg-white/70 hover:bg-white/90
                        transition-all">
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-white text-lg mb-2 drop-shadow">Confirm Password : </label>
                        <input 
                        type="password"
                        class="w-full border border-white/40 rounded-xl p-4 text-black text-lg 
                        focus:border-orange-400 outline-none bg-white/70 hover:bg-white/90
                        transition-all">
                    </div>
                </div>
                

                <!-- Button -->
                <div>
                    <button type="submit" 
                    class="font-medium py-3 mb-2 w-full rounded-3xl text-white text-2xl
                    bg-linear-to-r/oklch from-red-500 via-orange-400 to-yellow-300
                    shadow-lg hover:shadow-xl hover:scale-[1.05]
                    transition-all duration-300">
                    Masuk
                </button>
                
                <p class="text-slate-200 text-center">
                    Sudah punya akun? 
                    <a href="login.php" class="text-white font-semibold hover:underline">
                        Masuk!
                    </a>
                </p>
            </div>
        </form>
        <!-- Form End -->
    </div>
    <!-- Form Card End -->
</section>
</main>
<!-- Main End -->
</body>
</html>