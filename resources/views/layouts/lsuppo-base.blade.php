<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="containe mx-auto max-w-7xl text-xl" >
        <div id="app" class="text-gray-800">
            <div>
                <x-lsuppo-header :userName="$userName"/>
            </div>
            <div class="bg-white-100 mt-16 md:mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="menubar">
                            <x-hogoshamenu />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="content overflow-auto">
                        @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer border-top sticky-bottom">
                <x-lsuppo-footer />
            </div>
        </div>
    <script>
       const app= new Vue({
        el:'#app',
        data:{
            isOpen:false,
        }
       })
    </script> 
    </body>
</html>