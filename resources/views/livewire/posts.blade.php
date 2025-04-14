<div>
    @section('title')
        Kegiatan
    @endsection
    <section class="py-20">
        <div class="container pt-8 px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Kegiatan
                </h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <div class="card-xs sm:card md:card-md lg:card-lg xl:card-xl">
                            <figure>
                                <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                    src="{{ $post->getSingleImage() }}" alt="Gambar">
                            </figure>
                            <div class="card-body p-0 mt-2">
                                <h2 class="card-title text-xs lg:text-base">{{ $post->title }}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</div>
