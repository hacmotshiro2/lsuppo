<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ERROR</title>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
                <div class="flex flex-col items-center">
                    <!-- logo - start -->
                    <x-lsuppo-logo />
                    <!-- logo - end -->

                    <p class="text-indigo-500 text-sm md:text-base font-semibold uppercase mb-4">新規ユーザーが登録されました</p>
                    <h1 class="text-gray-800 text-2xl md:text-3xl font-bold text-center mb-2">紐づけ作業を行ってください。</h1>

                    <p class="max-w-screen-md text-gray-500 md:text-lg text-center mb-12">登録名:{{ $name }}</p>

                    <a href="{{env('APP_URL').App\Providers\RouteServiceProvider::HOME}}" class="inline-block bg-gray-200 hover:bg-gray-300 focus-visible:ring ring-indigo-300 text-gray-500 active:text-gray-700 text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">登録画面へ</a>
                </div>
            </div>
        </div>
    </body>
</html>