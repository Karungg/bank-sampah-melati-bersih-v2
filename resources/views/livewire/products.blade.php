<div>
    @section('title')
        Hasil Pengolahan
    @endsection
    <section class="py-20">
        <div class="container pt-8 px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Hasil Pengolahan
                </h1>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="card">
                        <figure>
                            <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                src="{{ $product->getThumbnail() }}" alt="Shoes" />
                        </figure>
                        <div class="card-body p-0 mt-3">
                            <h2 class="text-sm md:text-base card-title">{{ $product->title }}</h2>
                            <p class="text-xs md:text-sm">{{ $product->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</div>
