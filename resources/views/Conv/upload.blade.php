
@extends('layouts.lsuppo-base')

@section('title')
会話記録アップロード
@endsection
      
@section('content')
<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
    <!-- text - start -->
    <div class="mb-10 md:mb-16">
      <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-6">会話記録のアップロード</h2>
    </div>
    <!-- text - end -->

    <!-- form - start -->
    <form  method="POST" action="/conv/confirm" enctype="multipart/form-data" class="max-w-screen-md gap-4 mx-auto">
        @csrf
        <div class="mb-2 md:mb-4">
            <label for="LearningRoomCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">LRコード*</label>
            <select class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="LearningRoomCd" name="LearningRoomCd">
              <!-- 空白行入れる -->
                  <option value="" >----</option>
              @foreach($lrs as $lr)
                  <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
              @endforeach
            </select>
        </div>
        <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            <label class="block text-gray-800 text-sm sm:text-base my-2">音声記録（テキストファイル）</label>
            <input type="file" name="uploadTXT" accept="text/plain">
            <!-- ゆくゆくは -->
            <!-- <label class="block text-gray-800 text-sm sm:text-base mb-2">音声記録（音声ファイル）</label> -->
            <!-- <input type="file" name="uploadMP4"> -->
            <label for="SessionDate" class="block text-gray-800 text-sm sm:text-base my-2">セッション開催日*</label>
            <input type="date" name="SessionDate" class="w-full sm:w-1/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{old('SessionDate')}}"></input>
        </div>
        <div class="sm:col-span-2 mt-8 ">
          <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">コメント（補足）</label>
          <textarea name="Comment" rows="3" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" >{{old('Comment')}} </textarea>
      </div>
      <div class="sm:col-span-2 flex justify-between items-center my-2">
        <button class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">
             アップロード
        </button>
      </div>
    </form>
    <!-- form - end -->
  </div>
</div>

@endsection