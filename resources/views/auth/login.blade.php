<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                <x-lsuppo-logo />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="block my-2 md:mb-8 underline text-sm text-gray-600 hover:text-gray-900 ml-3" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="block w-full mt-4">
                {{-- <x-button class="w-3/5 text-center px-12 md:h-24 bg-gray-700 hover:bg-gray-500 text-lg hover:underline">
                    {{ __('Log in') }}
                </x-button> --}}
                <button class="block w-4/5 text-center px-12 h-12 md:h-24 mx-auto bg-gray-700 hover:bg-gray-500 rounded-xl text-lg text-white focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 hover:underline">
                    {{ __('Log in') }}
                </button>

            </div>
    {{-- -- No. h.hashimoto 2022/12/02 ------> --}}
    {{-- <hr class="border-dashed border-1 border-gray-600 mt-4"> --}}
    <div class="w-fit mx-auto mt-4 md:mt-8">
        <a href="/line/login"><img src="/images/btn_login_base.png" /></a>
    </div>
    {{-- -- <------  No. h.hashimoto 2022/12/02  --}}
    <!-- No. h.hashimoto 2022/08/18 ------> 
    <hr class="border-dashed border-1 border-gray-600 my-4">
    <div class="w-fit mx-auto">
        <a class="text-lg text-gray-600 hover:text-gray-900" href="{{ route('register') }}/1">
        保護者の方の新規登録はこちらから
        </a>
    </div>
    <!-- <------  No. h.hashimoto 2022/08/18  -->

        </form>
    </x-auth-card>
</x-guest-layout>
