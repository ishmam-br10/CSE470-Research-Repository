<x-guest-layout>
    <x-authentication-card>
        <!-- Empty logo slot - we'll place it manually inside the card -->
        <x-slot name="logo">
            <!-- Intentionally left empty -->
        </x-slot>
        
        <!-- Background image with proper positioning and overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-indigo-900/70"></div>
            <img src="{{ asset('images\animate.gif') }}" alt="Research Background" 
                class="w-full h-full object-cover opacity-40">
        </div>
        
        <!-- White card to hold login components -->
        <div class="relative z-10 bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto mt-12">
            <!-- Logo placed inside the card -->
            <div class="flex justify-center mb-6">
                <x-authentication-card-logo />
            </div>
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign in to your account</h2>
            
            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>

            <!-- New section with sign-up button -->
            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-3">Don't have an account?</p>
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-800 transition">
                    {{ __('Create Account') }}
                </a>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>