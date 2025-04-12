<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
    }
}"
    :data-theme="darkMode ? 'dark' : 'light'" x-init="$watch('darkMode', value => localStorage.setItem('theme', value ? 'dark' : 'light'))">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @if (Route::is('transaction.index'))
        <link rel="stylesheet" href="{{ asset('assets/dataTables/css/dataTables.tailwindcss.css') }}">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navigation')
    <div class="min-h-screen">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @include('partials.footer')

    @if (Route::is('transaction.index'))
        <script src="{{ asset('assets/dataTables/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/dataTables.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/dataTables.tailwindcss.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/dataTables.buttons.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/buttons.dataTables.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/buttons.print.min.js') }}"></script>
        <script>
            function filterGlobal(table) {
                let filter = document.querySelector('#filter');

                table.search(filter.value, false, true).draw();
            }

            let table = new DataTable('#transactions', {
                layout: {
                    topStart: false,
                    bottomEnd: {
                        paging: {
                            firstLast: false
                        }
                    }
                },
                buttons: [{
                        extend: 'copy',
                        className: 'btnCopy',
                    },
                    {
                        extend: 'excel',
                        className: 'btnExcel',
                    },
                    {
                        extend: 'pdf',
                        className: 'btnPdf',
                    },
                    {
                        extend: 'print',
                        className: 'btnPrint',
                    },
                ]
            });

            document.querySelector('#buttonCopy').addEventListener('click', function() {
                table.button('.btnCopy').trigger();
            });

            document.querySelector('#buttonExcel').addEventListener('click', function() {
                table.button('.btnExcel').trigger();
            });

            document.querySelector('#buttonPdf').addEventListener('click', function() {
                table.button('.btnPdf').trigger();
            });

            document.querySelector('#buttonPrint').addEventListener('click', function() {
                table.button('.btnPrint').trigger();
            });

            document.querySelectorAll('input.filter').forEach((el) => {
                el.addEventListener(el.type === 'text' ? 'keyup' : 'change', () =>
                    filterGlobal(table)
                );
            });

            const oldSearch = document.querySelector('.col-start-2');
            oldSearch.classList.add('hidden');
        </script>
    @endif
</body>

</html>
