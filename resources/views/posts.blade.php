@section('title')
    Kegiatan
@endsection
<x-app-layout>
    <section class="py-20">
        <div class="container pt-8 px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Kegiatan
                </h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @for ($i = 0; $i < 8; $i++)
                    <div class="card-xs sm:card md:card-md lg:card-lg xl:card-xl">
                        <figure>
                            <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                src="{{ asset('assets/images/posts/post-1.jpg') }}" alt="Gambar">
                        </figure>
                        <div class="card-body p-0 mt-2">
                            <h2 class="card-title text-xs lg:text-base">Kegiatan Transfer Knowledge
                                Green Economy dan
                                Workshop Pengolahan
                                Sampah
                                Anorganik</h2>
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