<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head prefix="og: https://ogp.me/ns#">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:url" content="https://lsuppo.manabiail-steam.com" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content=@yield('title') />
        <meta property="og:description" content="プログラミングスクールL会員向けアプリです" />
        <meta property="og:site_name" content="エルサポ" />
        <meta property="og:image" content="https://lsuppo.manabiail-steam.com/images/lsuppo-thumbnail.png" />

        <title>@yield('title')</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        @yield('pageCSS')

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- livewireで決まり文句 -->
        @livewireStyles

        <!-- Fontawesome -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <style type="text/css">
            @tailwind base;
            @tailwind components;
            @tailwind utilities;

            @layer base{
                label {
                    @apply inline-block text-gray-800 text-sm sm:text-base ;
                }
                input{
                    @apply bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 ;
                }

            }

            .sorticon{
             visibility: hidden;
                color: darkgray;
            }
            .sort:hover .sorticon{
                visibility: visible;
            }
            .sort:hover{
                cursor: pointer;
            }
        </style>
    </head>
    <body class="container mx-auto text-xl text-gray-800" >
        <!-- id=app は下のVuewスクリプトで使われているので消さない -->
        <div id="app" class="container">
            <div>
                <x-lsuppo-header :userName="$userName"/>
            </div>
            <div class="bg-white-100 mt-16 md:mt-44">
                <div>
                    <div wire:offline>
                        <x-lsuppo-alert-warning :alert=""接続が不安定です"" />
                    </div>
                    @if(!empty($alertComp))
                    <x-lsuppo-alert-completed :alert="$alertComp" />
                    @endif
                    @if(!empty($alertErr))
                    <x-lsuppo-alert-error :alert="$alertErr" />
                    @endif
                    @if(count($errors) > 0)
                    <!-- 配列はそのままでは送れないのでＪＳＯＮに変換 -->
                    <x-lsuppo-alert-error :errorJson="json_encode($errors->all())" />
                    @endif
                    @if(!empty($alertInfo))
                    <x-lsuppo-alert-information :alert="$alertInfo" />
                    @endif
                    @if(!empty($alertWar))
                    <x-lsuppo-alert-warning :alert="$alertWar" />
                    @endif
                </div>
                <div class="content overflow-none ">
                @yield('content')
                </div>
            </div>
            <!-- フッターと重なるので空白を入れる -->
            <div class="h-12"></div>
            {{-- <div class="w-full fixed bottom-1 z-50"> ずっと見えておく必要もないので--}}
            <div class="w-full z-50">
                <x-lsuppo-footer />
            </div>
        </div>
    <script>
       const app= new Vue({
        //ハンバーガーメニュー用
        el:'#app',
        data:{
            isOpen:false,
            ismvOpen:false,
        }
       });
       //このやり方は間違っている↓
       //    const appMV= new Vue({
       //     //動画と作品ドロップダウンメニュー用
       //     el:'#app',
       //     data:{
       //         ismvOpen:false,
       //     }
       //    });
    </script> 
    <script type="text/javascript">
        // FB登録画面で、文字数をカウントします
        const textarea = document.querySelector('#txtaDetail');
        const detail_length = document.querySelector('#detail_length');
        //イベント登録
        textarea.addEventListener('keyup', onKeyUp);
        function onKeyUp(){
            detail_length.innerText = textarea.value.length;
        }
        //LC削除時の確認処理
        function onDelete(){
            if(window.confirm('削除します。よろしいですか？')){
                return true;
            }
            else{
                return false;
            }
        }
        // const formLCDelete = document.querySelector('#formLCDelete');
        // formLCDelete.addEventListener('onsubmit',(event)=>{
        //     return window.confirm();
        // });
    </script>
    <!-- <script src="../path/to/flowbite/dist/flowbite.js"></script> -->
    <!-- Flowbite追加 -->
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    @yield('pageScript')

    @livewireScripts
    </body>
</html>