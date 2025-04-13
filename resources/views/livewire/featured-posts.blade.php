<div>
    <section class="pb-20">
        <div class="container px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Kegiatan bank sampah
                </h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ($posts as $post)
                    <a href="{{ $post->link }}" target="_blank">
                        <div
                            class="last:w-1/2 last:mx-auto last:col-span-2 sm:last:w-auto sm:last:mx-0 sm:last:col-span-1">
                            <div class="card-xs sm:card md:card-md lg:card-lg xl:card-xl">
                                <figure>
                                    <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                        src="{{ $post->getSingleImage() }}" alt="Gambar">
                                </figure>
                                <div class="card-body p-2 mt-2">
                                    <h2 class="card-title text-xs lg:text-base">{{ $post->title }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('posts') }}" wire:navigate.hover class="btn btn-link">
                    Lihat selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>
