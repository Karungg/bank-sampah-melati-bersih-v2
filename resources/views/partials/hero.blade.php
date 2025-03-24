<div class="hero min-h-screen bg-cover bg-center"
    style="background-image: url({{ asset('assets/images/hero-bg.jpg') }});">
    <div class="hero-overlay bg-black/50"></div>
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between text-white relative z-10">
        <div class="w-full md:w-1/2 text-left mb-10 md:mb-0">
            <h1 class="text-4xl sm:text-6xl font-bold mb-5">Bank Sampah Melati Bersih Atsiri Permai</h1>
            <p class="text-2xl mb-5">Mengubah sampah menjadi uang</p>
            <button class="btn btn-success text-white">Bergabung</button>
        </div>
        <div class="w-full md:w-1/3 text-center justify-items-center">
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                <path d="M12 5V19M12 19L7 14M12 19L17 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            <button class="btn btn-warning text-white" onclick="annountcement.showModal()">Lihat pengumuman</button>
        </div>
    </div>
</div>