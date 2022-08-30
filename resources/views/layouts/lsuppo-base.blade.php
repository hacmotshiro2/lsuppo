<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
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

        </style>
    </head>
    <body class="containe mx-auto max-w-7xl text-xl text-gray-800" >
        <!-- id=app は下のVuewスクリプトで使われているので消さない -->
        <div id="app">
            <div>
                <x-lsuppo-header :userName="$userName"/>
            </div>
            <div class="bg-white-100 mt-16 md:mt-2">
                <div>
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
                <div class="content overflow-auto">
                @yield('content')
                </div>
            </div>
            <div class="footer border-top sticky-bottom">
                <x-lsuppo-footer />
            </div>
        </div>
    <script>
       const app= new Vue({
        //ハンバーガーメニュー用
        el:'#app',
        data:{
            isOpen:false,
        }
       })
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
    </body>
</html>