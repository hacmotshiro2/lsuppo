<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                <x-lsuppo-logo />
            </a>
        </x-slot>
        @if($tourokuUserType == 1)
        <H2 class="text-gray-900">保護者様用 登録ページ</H2>
        @elseif($tourokuUserType == 3)
        <H2 class="text-gray-900">サポーター用 登録ページ</H2>
        @else
        <!-- ここには来ない想定 -->
        @endif 

        <!-- Validation Errors -->
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        {{-- No. h.hashimoto 2022/12/10 ------> --}}
        @if($tourokuUserType == 1)
        <div class="my-2 sm:my-6">
            <hr class="border-dashed border-1 border-gray-600">
            <div class="block my-4">
                <div class="block mt-4 mb-2 w-full">
                    <a href="/line/create">
                        <button class="block mx-auto w-fit text-center rounded-lg px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white  tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-30 transition ease-in-out duration-150" style="background-color:#06C755" >LINEでログインできるようにする</button>
                    </a>
                    <p class="text-sm mt-2 text-gray-700 w-2/3 mx-auto">LINEでログインできるようにするにはまずこちらを押してLINE紐づけをONにしてください</p>
                </div>
                <div class="w-fit mx-auto">
                    {{-- Component化 --}}
                    {{-- <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" disabled {{$bindChecked}}>
                        <div class="w-14 h-7 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-400 dark:text-gray-500">LINE 紐づけ</span>
                    </label> --}}
                    <x-lsuppo-toggle :bindChecked="$bindChecked" :description="'LINE 紐づけ'" />
                </div>
            </div>
        </div>
        @endif
        {{-- <------  No. h.hashimoto 2022/12/10  --}}
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" id="tourokuUserType" name="tourokuUserType" value="{{$tourokuUserType}}" />
            <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- StudentName -->
            @if($tourokuUserType==1)
            <div class="mt-4">
                <x-label for="student_name" value="お子様のお名前" />
                <x-input id="student_name" class="block mt-1 w-full" type="text" name="student_name" :value="old('student_name')" required autofocus />
            </div>
            @endif
            
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>


            <div class="flex items-center justify-center mt-4">

                <x-button class="ml-4 px-16">
                    {{ __('Register') }}
                </x-button>
            </div>
            {{-- -- No. h.hashimoto 2022/12/10 ------> --}}
            <input type="hidden" name="line_user_id" value="{{$line_user_id}}"/>
            {{-- -- <------  No. h.hashimoto 2022/12/10  --}}
        </form>
    </x-auth-card>
</x-guest-layout>
