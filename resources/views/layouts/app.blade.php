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
    @livewireStyles
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
            new DataTable('#transactions', {
                language: {
                    search: 'Cari : ',
                },
                layout: {
                    topStart: {
                        div: {
                            html: '<div class="flex flex-wrap gap-2 sm:flex-nowrap"><div id="custom-buttons"></div></div>'
                        }
                    },
                    topEnd: {
                        search: {}
                    }
                },
                initComplete: function() {
                    const table = this.api();

                    function debounce(func, wait) {
                        let timeout;
                        return function() {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => func.apply(this, arguments), wait);
                        };
                    }

                    function setupButtons() {
                        $('#custom-buttons').empty();
                        let buttons;

                        if (window.innerWidth >= 640) {
                            buttons = new $.fn.dataTable.Buttons(table, {
                                buttons: [{
                                        extend: 'copy',
                                        text: '<span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" /></svg><p>Copy</p></span>',
                                        className: 'btn btn-sm'
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<span class="flex items-center gap-1 text-green-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg><p class="text-gray-800 dark:text-gray-100">Excel</p></span>',
                                        className: 'btn btn-sm'
                                    },
                                    {
                                        extend: 'pdf',
                                        text: '<span class="flex items-center gap-1 text-red-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg><p class="text-gray-800 dark:text-gray-100">Pdf</p></span>',
                                        className: 'btn btn-sm'
                                    },
                                    {
                                        extend: 'print',
                                        text: '<span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg><p>Print</p></span>',
                                        className: 'btn btn-sm'
                                    },
                                ]
                            }).container();
                        } else {
                            buttons = new $.fn.dataTable.Buttons(table, {
                                buttons: [{
                                    extend: 'collection',
                                    className: 'custom-html-collection',
                                    buttons: [
                                        '<h3>Export</h3>',
                                        'pdf',
                                        'csv',
                                        'excel',
                                        '<h3 class="not-top-heading">Column Visibility</h3>',
                                        'columnsToggle'
                                    ]
                                }]
                            }).container();
                        }

                        $('#custom-buttons').append(buttons);
                    }

                    setupButtons();

                    window.addEventListener('resize', debounce(setupButtons, 300));
                }
            });
        </script>
    @endif
    @livewireScripts
</body>

</html>
