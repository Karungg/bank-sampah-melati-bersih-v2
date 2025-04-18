@section('title')
    Verifikasi Email
@endsection
<x-app-layout>
    <section class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col px-4 justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-gray-900">
            <div>
                <h1 class="text-gray-700 dark:text-gray-300 text-2xl uppercase font-bold">Verifikasi email</h1>
            </div>

            <div
                class="w-full max-w-md mt-6 px-6 py-4 bg-gray-100 dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-primary-button>
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
