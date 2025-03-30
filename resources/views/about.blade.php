@section('title')
    Tentang Kami
@endsection
<x-app-layout>
    <section class="py-20">
        <div class="container pt-6 lg:pt-14 px-4 w-full mx-auto flex flex-col items-center">
            <div class="max-w-5xl mb-8 lg:mb-16">
                <img class="rounded-sm" src="{{ asset('assets/images/hero-about.jpg') }}" alt="">
            </div>
            <div class="grid grid-cols-1 gap-8 lg:gap-12 max-w-5xl w-full">
                <div class="flex flex-col text-left">
                    <p class="text-xl md:text-2xl lg:text-3xl font-bold">Tentang Bank Sampah Atsiri Permai</p>
                    <p class="text-sm md:text-base lg:text-lg text-justify mt-4">
                        Website BSMB Atisiri Permai ini merupakan hibah dari Direktorat Riset, Teknologi, dan
                        Pengabdian kepada Masyarakat (DRTPM) Tahun Anggaran 2024, Direktorat Jenderal Pendidikan
                        Tinggi, Riset, dan Teknologi, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi
                        Republik Indonesia.
                    </p>
                </div>
                <div class="flex flex-col items-center">
                    <p class="text-xl md:text-2xl lg:text-3xl font-bold text-center">Struktur Organisasi
                    </p>
                    <div class="shadow-xs max-w-1/2 rounded-sm overflow-hidden mt-4">
                        <img class="w-full" src="{{ asset('assets/images/structure-organization.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>