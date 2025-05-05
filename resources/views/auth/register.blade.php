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
        
        <!-- White card to hold registration components -->
        <div class="relative z-10 bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto mt-8">
            <!-- Logo placed inside the card -->
            <div class="flex justify-center mb-6">
                <x-authentication-card-logo />
            </div>
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an account</h2>
            
            <!-- BRAC University domains notice -->
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                <p class="text-sm text-blue-700">
                    <span class="font-semibold">Note:</span> Only BRAC University email domains are allowed (@g.bracu.ac.bd or @bracu.ac.bd).
                </p>
            </div>
            
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" id="registration-form">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input 
                        id="email" 
                        class="block mt-1 w-full" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username"
                        pattern="[a-zA-Z0-9._%+-]+@(g\.bracu\.ac\.bd|bracu\.ac\.bd)$"
                        title="Please enter a valid BRAC University email (@g.bracu.ac.bd or @bracu.ac.bd)"
                    />
                    <p class="mt-1 text-xs text-gray-500">Must be a BRAC University email (@g.bracu.ac.bd or @bracu.ac.bd)</p>
                </div>

                <div class="mt-4">
                    <x-label for="role" value="{{ __('Role') }}" />
                    <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="researcher">Researcher</option>
                        <option value="non-researcher">Non-Researcher</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
            
            <!-- Login link section -->
            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-3">Already have an account?</p>
                <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-200 active:bg-gray-400 transition">
                    {{ __('Sign In') }}
                </a>
            </div>
        </div>
    </x-authentication-card>
    
    <!-- Client-side validation script -->
    <script>
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const validDomains = ['@g.bracu.ac.bd', '@bracu.ac.bd'];
            
            let isValid = false;
            for (const domain of validDomains) {
                if (email.endsWith(domain)) {
                    isValid = true;
                    break;
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                alert('Please use a valid BRAC University email address (@g.bracu.ac.bd or @bracu.ac.bd)');
            }
        });
    </script>
</x-guest-layout>