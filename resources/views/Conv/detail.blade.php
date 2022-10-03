@extends('layouts.lsuppo-base')

@section('title')
CLOVA会話明細
@endsection

@section('content')
<!-- reffer: https://flowbite.com/docs/components/tables/#table-with-modal -->
<div class="relative shadow-md sm:rounded-lg">
    <!-- ヘッダ部分 -->
    <div class="mx-3">
        <p><a href="{{route('conv-index')}}" class="mb-4 text-gray-400">＜ 一覧へ戻る</a></p>
        <!-- 参加者 -->
        <div class="flex flex-wrap">
            <span scope="col" class="py-1 px-6">参加者</span>
            <form method="POST" action="#">
                @csrf
                <input type="hidden" name="headerId" value="{{$headerId}}">
                <button formaction="/conv/detail" class="rounded text-xs inline-block bg-indigo-500 hover:bg-red-600 active:bg-gray-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-4 py-2 mx-2 my-2" name="OriginalSpeaker" >フィルター解除</button>
                @foreach($speakers as $speaker)
                    <button formaction="/conv/detail?orgSpeaker={{$speaker->OriginalSpeaker}}" class="rounded text-xs inline-block bg-gray-500 hover:bg-red-600 active:bg-gray-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-4 py-2 mx-2 my-2" name="OriginalSpeaker" value="{{$speaker->OriginalSpeaker}}" >{{$speaker->OriginalSpeaker}}</button>
                @endforeach
            </form>
        </div>
        <!-- 参加者 end -->
        <!-- 発言者置き換えエリア  -->
        <div class="flex my-3">
            <form method="POST" action="/conv/replace">
            @csrf
                <input type="hidden" name="headerId" value="{{$headerId}}">
                <div class="flex">
                    <div class="mx-3">
                        <span>発言者</span>
                        <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-1" name="ddlOr">
                        <!-- 空白行入れる -->
                            <option value="" >----</option>
                        @foreach($ddlOriginals as $item)
                            @if($mode=='add')
                            <option value="{{$item->Cd}}" @if(old('ddlOr')==$item->Cd) selected @endif >{{$item->Name}}</option>
                            @elseif($mode=='edit')
                            <option value="{{$item->Cd}}" @if($cd==$item->Cd) selected @endif >{{$item->Name}}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="mx-3">
                        <span>候補者</span>
                        <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-1" name="ddlCan">
                        <!-- 空白行入れる -->
                            <option value="" >----</option>
                        @foreach($ddlCandidates as $item)
                            @if($mode=='add')
                            <option value="{{$item->CdName}}" @if(old('ddlCan')==$item->CdName) selected @endif >{{$item->CdName}}</option>
                            @elseif($mode=='edit')
                            <option value="{{$item->CdName}}" @if($cd==$item->CdName) selected @endif >{{$item->CdName}}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="mx-3">
                        <button formaction="/conv/replace" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-5 py-1">更新</button>
                        <input id="chkForce" name="chkForce[]" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="Force">セットされているものも含め更新
                    </div>
                </div>
            </form>
        </div>
        <!-- 発言者置き換えエリア end -->
    </div>
    <!-- ヘッダ部分 end-->
    <!-- 明細部 -->
    <div class="mx-3 overflow-auto " style="height:600px;">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <div class="sticky top-0">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">時間</th>
                        <th scope="col" class="py-3 px-6">オリジナル発言者</th>
                        <th scope="col" class="py-3 px-6">オリジナル会話</th>
                        <th scope="col" class="py-3 px-6">発言者コード</th>
                        <th scope="col" class="py-3 px-6">発言者名</th>
                        <th scope="col" class="py-3 px-6">コメント</th>
                        <th scope="col" class="py-3 px-6">Action</th>
                    </tr>
                </thead>
            </div>
            <tbody>
                @foreach($lines as $line)
                <!-- リダイレクト時に、今更新したidが指定されるので、該当行のカラーを変更 -->
                <tr class="@if($id==$line->id) bg-green-100 @else bg-white @endif border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <!-- 編集から戻ってきたとき用にアンカーをつけておく -->
                    <td class="p-4 w-4" id="id{{$line->id}}">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <!-- <td scope="row" class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white"> -->
                        <!-- <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image"> -->
                        <!-- <div class="pl-3"> -->
                            <!-- <div class="text-base font-semibold">Neil Sims</div> -->
                            <!-- <div class="font-normal text-gray-500">neil.sims@flowbite.com</div> -->
                        <!-- </div>   -->
                    <!-- </td> -->
                    <td class="py-1 px-2">{{$line->LineCount}}</td>
                    <td class="py-1 px-2">{{$line->OriginalTime}}</td>
                    <td class="py-1 px-2">{{$line->OriginalSpeaker}}</td>
                    <td class="py-1 px-2">{{$line->OriginalConversation}}</td>
                    <td class="py-1 px-2">{{$line->SpeakerCd}}</td>
                    <td class="py-1 px-2">{{$line->Speaker}}</td>
                    <td class="py-1 px-2">{{$line->Comment}}</td>
                    <td class="py-1 px-2">
                        <!-- Modal toggle -->
                        <!-- <a href="#" type="button" data-modal-toggle="editMeisaiModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a> -->
                        <a href="/conv/editMeisai/?id={{$line->id}}" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-1 bg-gray-100">
            {{$lines->appends(['headerId'=>$headerId])->links()}}
        </div>
    </div>
    <!-- 明細部 end -->
    {{-- <div class="container fixed flex justify-between bottom-4 md:bottom-10 bg-gray-100 content-center"> --}}
        {{-- <div class="px-6 py-1">
            <p><a href="{{route('conv-index')}}" class="mb-4 text-gray-700 sticky top-0 z-1">＜ 一覧へ戻る</a></p>
        </div>
        <div class="px-8 py-1">
            {{$lines->links()}}
        </div>
    </div> --}}
</div>
<script>
    //リダイレクトでidが指定されたときに、そこまでスクロール
    @if(!is_null($id))
    window.onload = function(){
        //
            var el = document.getElementById('id{{$id}}');
            el.scrollIntoView(true);
    }
    @endif
</script>
@endsection