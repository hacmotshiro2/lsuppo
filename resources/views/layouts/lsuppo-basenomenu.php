<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
         <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">       
        <style>
                body{font-size:16pt; color:#082233; margin:5px;}
                header{
                    width: 100%;
                    text-align: center;
                    padding: 20px;

                }
                footer{
                    width: 100%;
                    text-align: center;
                    padding: 15px;
                    /*
                    position: relative;
                    bottom:0;
                    */
                }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
    <div class="min-h-screen bg-gray-100">
         <header>
            <div class="header border-bottom">
                <x-header :userName="$userName"/>
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content overflow-auto">
                    @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer border-top sticky-bottom">
                <x-footer />
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    
    </body>
</html>