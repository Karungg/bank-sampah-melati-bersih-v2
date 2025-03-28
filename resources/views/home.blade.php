<x-app-layout>
    {{-- annountcement --}}
    <dialog id="annountcement" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">Press ESC key or click the button below to close</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    {{-- hero --}}
    <div class="hero min-h-screen bg-cover bg-center"
        style="background-image: url({{ asset('assets/images/hero-bg.jpg') }});">
        <div class="hero-overlay bg-black/50"></div>
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between text-white">
            <div class="w-full md:w-2/3 2xl:w-1/2 text-left mb-10 md:mb-0">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-5">Bank Sampah Melati Bersih Atsiri Permai</h1>
                <p class="text-lg sm:text-xl lg:text-2xl mb-5">Mengubah sampah menjadi uang</p>
                <button class="btn btn-success text-white">Bergabung</button>
            </div>
            <div class="w-full md:w-1/3 text-center justify-items-center">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                    <path d="M12 5V19M12 19L7 14M12 19L17 14" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <button class="btn btn-warning text-white" onclick="annountcement.showModal()">Lihat pengumuman</button>
            </div>
        </div>
    </div>

    {{-- about --}}
    <section class="py-20">
        <div class="container mx-auto px-4 flex flex-col-reverse lg:flex-row items-center justify-between">
            <div class="w-full mt-8 lg:mt-0 lg:w-2/3">
                <h1 class="text-xl md:text-2xl mb-5">
                    Bank Sampah Melati Bersih Atsiri Permai
                </h1>
                <p class="text-sm indent-8 md:text-base text-justify mb-5">
                    Mitra pada program PKM ini adalah Bank Sampah Melati Bersih Atsiri Permai RW 12, yang berdiri pada
                    tanggal 31 Agustus 2013, dengan lokasi sekretariat di Perumahan Atsiri Permai, Jl. Kenanga IV No.
                    13,
                    Desa Ragajaya, Kecamatan Bojonggede, Kabupaten Bogor. Kepengurusan Bank Sampah Melati Bersih Atsiri
                    Permai RW 12 memiliki moto "Gerakan Bersih dan Senyum"
                    yang berlandaskan konsep 3R (Reduce, Reuse, Recycle) sebagai lembaga penggerak pemberdayaan
                    masyarakat
                    dalam pengelolaan sampah yang efektif. Salah satu upaya yang dilakukan adalah memilah sampah
                    anorganik
                    dan mengumpulkan minyak jelantah sebagai penerapan konsep green economy, yang memberikan manfaat
                    besar
                    bagi perekonomian masyarakat serta kelestarian lingkungan. Jenis sampah anorganik dibagi menjadi 15
                    kategori, yaitu: emberan, boncos, kaleng, seng, besi,
                    aluminium, PE plastik, beling, kardus & kertas, kristal, botol, kabin, impact, lain-lain, dan
                    jelantah.
                </p>
            </div>
            <div class="flex w-full justify-center lg:w-1/4">
                <div class="shadow-sm w-96 rounded-lg overflow-hidden">
                    <img src="{{ asset('assets/images/about-bg.jpg') }}" alt="Tentang Kami">
                </div>
            </div>
        </div>
    </section>

    {{-- count --}}
    <section class="pb-20">
        <div class="container px-4 w-full mx-auto flex flex-col items-center">
            <div class="w-full text-center mb-12">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Dalam Angka</h1>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full max-w-xl">
                <div class="card flex flex-col items-center p-6">
                    <span class="countdown font-mono text-xl md:text-2xl lg:text-3xl font-bold">0+</span>
                    <p class="text-sm md:text-base lg:text-lg mt-2">Nasabah</p>
                </div>
                <div class="card flex flex-col items-center p-6">
                    <span class="countdown font-mono text-xl md:text-2xl lg:text-3xl font-bold">0+</span>
                    <p class="text-sm md:text-base lg:text-lg mt-2">Sampah terkumpul (Kg)</p>
                </div>
            </div>
        </div>
    </section>

    {{-- steps --}}
    <section class="pb-20">
        <div class="container mx-auto px-4 flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Alur Pendaftaran</h1>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">1. Nasabah memilah sampah di rumah
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">2. Datang ke lokasi bank sampah
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10 xmlns=" http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">3. Mendaftar nasabah baru
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10 xmlns=" http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">4. Menimbang sampah
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10 xmlns=" http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">5. Menerima bukti timbang
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-center">
                                <svg class="size-6 md:size-8 lg:size-10 xmlns=" http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>
                            </div>
                            <p class="text-sm sm:text-center md:text-base lg:text-lg">6. Login untuk mengecek status
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- featured posts --}}
    <section class="pb-20">
        <div class="container px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Kegiatan bank sampah</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @for ($i = 0; $i < 3; $i++)
                    <div class="last:w-1/2 last:mx-auto last:col-span-2 
                                        sm:last:w-auto sm:last:mx-0 sm:last:col-span-1">
                        <div class="card-xs sm:card md:card-md lg:card-lg xl:card-xl rounded">
                            <figure>
                                <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded"
                                    src="{{ asset('assets/images/posts/post-1.jpg') }}" alt="Gambar">
                            </figure>
                            <div class="card-body p-0 mt-2">
                                <h2 class="card-title text-xs lg:text-base">Kegiatan Transfer Knowledge Green Economy dan
                                    Workshop Pengolahan
                                    Sampah
                                    Anorganik</h2>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="mt-12 text-center">
                <button class="btn btn-link">
                    Lihat selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
</x-app-layout>