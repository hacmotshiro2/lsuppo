
@extends('layouts.lsuppo-base')

@section('title')
アップロード内容確認ページ
@endsection
      
@section('content')
<section>
    @if(isset($cth))
    <div class=" px-5 py-8 mx-auto">
        <form method="POST" action="/conv/upload" class="w-full mb-8 prose text-left ">
            @csrf
            <div class="w-full mx-auto">
                <label for="LearningRoomCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">LRコード*</label>
                <input type="text" class="w-full text-gray-800 text-xl font-bold text-center mb-4 md:mb-6 rounded" name="LearningRoomCd" value="{{$cth->LearningRoomCd}}" readonly>
                <input type="text" class="w-full text-gray-800 text-xl font-bold text-center mb-4 md:mb-6 rounded" name="FileName" value="{{$cth->FileName}}" readonly>
                <h3 class="text-gray-600 sm:text-lg mb-2 " >アップロード日時:</h3>
                <input type="text" class="text-gray-500 sm:text-lg mb-4 md:mb-6 rounded" name="UploadedDatetime" value="{{$cth->UploadedDatetime}}" readonly></input>
                <h3 class="text-gray-600 sm:text-lg mb-2 ">セッション日:</h3>
                <input type="text" class="text-gray-500 sm:text-lg mb-4 md:mb-6 rounded" name="SessionDate" value="{{$cth->SessionDate}}" readonly></input>
                <input type="hidden" name="FileID" value="{{$cth->FileID}}">
                <!-- <textarea type="text" class="w-full text-gray-800 sm:text-lg mb-8 md:mb-10 rounded" name="contents" rows="100" readonly>{!!nl2br(e($contents))!!}</textarea> -->
                <textarea type="text" class="w-full text-gray-800 sm:text-lg mb-8 md:mb-10 rounded" name="contents" rows="100" readonly>{{$contents}}</textarea>
            </div>
            <div class="sm:col-span-2 mt-8 ">
              <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">コメント（補足）</label>
              <textarea name="Comment" rows="3" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none px-3 py-2" readonly >{{$cth->Comment}} </textarea>
            </div>

            <div class="w-full px-5 py-2 mx-auto mb-8">
                <div class="flex justify-center gap-2.5">
                    <button formaction="/conv/upload" class="w-full block bg-indigo-400 hover:bg-indigo-600 active:bg-indigo-600 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">アップロード</button>
                </div>
            </div>
        </form>
        <p><a class="text-indigo-500" href='/conv/upload'>&lt;戻る</a></p>
    </div>
    @else
    <p>ページ遷移が不正です</p>
    @endif
</section>
@endsection