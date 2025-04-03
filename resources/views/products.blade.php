@section('title')
    Hasil Pengolahan
@endsection
<x-app-layout>
    <section class="py-20">
        <div class="container pt-8 px-4 mx-auto flex flex-col">
            <div class="mb-12 text-center">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Hasil Pengolahan
                </h1>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for ($i = 0; $i < 4; $i++)
                    <div class="card">
                        <figure>
                            <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                src="{{ asset('assets/images/products/product-1.JPG') }}" alt="Shoes" />
                        </figure>
                        <div class="card-body p-0 mt-3">
                            <h2 class="card-title">Tas</h2>
                            <p>Hasil Pengolahan Sampah Anorganik Sachet Dari Bungkus Kopi Menjadi Keranjang
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <figure>
                            <img class="w-full h-24 sm:h-36 xl:h-64 object-cover rounded-md"
                                src="{{ asset('assets/images/products/product-2.jpg') }}" alt="Shoes" />
                        </figure>
                        <div class="card-body p-0 mt-3">
                            <h2 class="card-title">Taplak</h2>
                            <p>Hasil Pengolahan Sampah Anorganik Sachet Dari Bungkus Kopi Menjadi Taplak Meja
                            </p>
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
