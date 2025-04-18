<footer
    class="footer sm:footer-horizontal bg-gray-100 dark:bg-gray-800 text-base-content px-4 py-10 sm:justify-items-center">
    <aside>
        <img class="h-12 md:h-24" src="{{ asset('assets/images/logo.png') }}" alt="">
        <p>
            Bank Sampah Melati Bersih</br>Atsiri Permai
        </p>
    </aside>
    <nav>
        <h6 class="footer-title">Didukung Oleh</h6>
        <div class="flex">
            <img class="h-12 lg:h-20" src="{{ asset('assets/images/logo-1.png') }}" alt="">
            <img class="h-12 lg:h-20" src="{{ asset('assets/images/logo-2.png') }}" alt="">
        </div>
    </nav>
    <nav>
        <h6 class="footer-title">Organisasi</h6>
        <a href="{{ route('about') }}" class="link link-hover">Tentang Kami</a>
    </nav>
</footer>
