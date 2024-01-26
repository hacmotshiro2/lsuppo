{{-- r_mv_presentationの1レコードを渡し、表示するコンポーネンツ（サブビュー） --}}
<div class="bg-gray-900 rounded overflow-hidden">
    <!-- content - start -->
    <!-- content - end -->

    <div class="w-full bg-gray-700 ">
        <div class="">
            <iframe width="100%" class="top-0 left-0 aspect-video" src="https://www.youtube-nocookie.com/embed/{{$item->YouTubeId}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
        </div>
    </div>
    <div class="w-full flex flex-col p-2 sm:p-4">
        <h2 class="text-white text-xl font-bold mb-4">{{$item->Title}}</h2>
        <h6 class="text-white mb-2">発表した日: {{$item->ShootingDate}}</h6>
        <p class="max-w-md text-gray-400 mb-8">{{$item->Description}}</p>
    </div>
</div>