<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-lsuppo-logo />
            </a>
        </div>
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="py-6 sm:py-8 lg:py-12">
                <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
                    <!-- text - start -->
                    <div class="mb-10 md:mb-16">
                        <p class="max-w-screen-md text-gray-800 md:text-xl text-center mx-auto">LINEでログインするための事前設定がまだのようです</p>
                    </div>
                    <!-- text - end -->
                
                    <div class="grid sm:grid-rows-5 sm:grid-cols-2 grid-flow-col gap-6">
                        {{-- 1列目 --}}
                        <!-- product - start -->
                        <div>
                            <h4 class="text-gray-700">すでにエルサポに登録済みの方はこちら</h4>
                            <p class="text-gray-400">ログイン後、設定画面からLINEとの紐づけを行っていただきます</p>
                        </div>
                        <!-- product - end -->
                
                        <!-- product - start -->
                        <div class="row-span-4">
                            <a href="/settings" class="group h-80 flex items-end bg-gray-100 rounded-lg overflow-hidden shadow-lg relative p-4">
                                <img src="/images/already-registered.png" loading="lazy" alt="Photo by Fakurian Design" class="w-full h-full object-cover object-center absolute inset-0 group-hover:scale-110 transition duration-200" />
                                <div class="bg-gradient-to-t from-gray-800 via-transparent to-transparent opacity-50 absolute inset-0 pointer-events-none"></div>
                            </a>
                        </div>
                        <!-- product - end -->
                
                        {{-- 2列目 --}}
                        <!-- product - start -->
                        <div>
                            <h4 class="text-gray-700">これからエルサポに登録する方はこちら</h4>
                            <p class="text-gray-400">LINEの情報で初期登録していただきます</p>
                        </div>
                        <!-- product - end -->

                        <!-- product - start -->
                        <div class="row-span-4">
                            <a href="/register/1" class="group h-80 flex items-end bg-gray-100 rounded-lg overflow-hidden shadow-lg relative p-4">
                                <img src="/images/new-registration.png" loading="lazy" alt="Photo by Fakurian Design" class="w-full h-full object-cover object-center absolute inset-0 group-hover:scale-110 transition duration-200" />
                                <div class="bg-gradient-to-t from-gray-800 via-transparent to-transparent opacity-50 absolute inset-0 pointer-events-none"></div>
                            </a>
                        </div>
                        <!-- product - end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
