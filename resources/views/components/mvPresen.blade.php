{{-- r_mv_presentationの1レコードを渡し、表示するコンポーネンツ（サブビュー） --}}
<div class=" flex flex-col sm:flex-row bg-gray-900 rounded-md overflow-hidden">
    <!-- content - start -->
    <div class="w-full sm:w-1/2 lg:w-1/4 flex flex-col p-4 sm:p-8">
    <h2 class="text-white text-xl md:text-2xl lg:text-4xl font-bold mb-4">{{$item->Title}}</h2>
    <h6 class="text-white lg:text-xl mb-4">発表した日: {{$item->ShootingDate}}</h6>
    <p class="max-w-md text-gray-400 mb-8">{{$item->Description}}</p>
    </div>
    <!-- content - end -->

    <div class="w-full sm:w-1/2 lg:w-3/4 sm:h-auto order-first sm:order-none bg-gray-700 ">
        {{-- 動画エリア　スクリーンサイズによって視聴サイズを変更する sm640 md768 lg1024 xl1280--}}
        {{-- 640px未満 --}}
        <div class="not-sr-only md:sr-only">
            <iframe width="336" height="189" src="https://www.youtube-nocookie.com/embed/{{$item->YouTubeId}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
        </div>
        {{-- 640px以上 1024px未満 --}}
        <div class="sr-only md:not-sr-only lg:sr-only">
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/{{$item->YouTubeId}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
        </div>
        {{-- 1024px以上 --}}
        <div class="sr-only lg:not-sr-only">
            <iframe width="728" height="409.5" src="https://www.youtube-nocookie.com/embed/{{$item->YouTubeId}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
        </div>
    </div>
</div>