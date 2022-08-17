<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" >
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

    </head>
    <body>
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" ></script>
        <header>
            <div class="header border-bottom">
                <x-header />
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
    </body>
</html>