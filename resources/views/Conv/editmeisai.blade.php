
@extends('layouts.lsuppo-base')

@section('title')
会話明細の更新ページ
@endsection
      
@section('content')
<div class="">
    <form method="POST" action="/conv/editMeisai" class="row g-2">
    @csrf
        <input type="hidden" name="id" value="{{$item->id}}">
        <div class="grid grid-cols-3 gap-4">
            <!-- 左半分　更新しないエリア -->
            <!-- 右半分　更新エリア -->
            <!-- ヘッダ -->
            <div>
            </div>
            <div class="text-center">
                <label class="">-更新前-</label>
            </div>
            <div class="text-center">
                <label class="">-更新する-</label>
            </div>
            <!-- LineCount -->
            <div class="mb-2">
                <label class="form-label">LineCount</label>
            </div>
            <div>
                <label>{{$item->LineCount}}</label>
            </div>
            <div>
            </div>
            <!-- オリジナル発言者 -->
            <div class="mb-2">
                <label class="form-label">オリジナル発言者</label>
            </div>
            <div>
                <label>{{$item->OriginalSpeaker}}</label>
            </div>
            <div>
            </div>
            <!-- オリジナルTime -->
            <div class="mb-2">
                <label class="form-label">オリジナルTime</label>
            </div>
            <div>
                <label>{{$item->OriginalTime}}</label>
            </div>
            <div>
            </div>
            <!-- オリジナル会話 -->
            <div class="mb-2">
                <label class="form-label">オリジナル会話</label>
            </div>
            <div>
                <label>{{$item->OriginalConversation}}</label>
            </div>
            <div>
            </div>
            <!-- 発言者コード -->
            <div class="mb-2">
                <label class="form-label">発言者コード</label>
            </div>
            <div>
                <label>{{$item->SpeakerCd}}</label>
            </div>
            <div>
                <select class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-1" name="ddlSpeakerCd">
                        <!-- 空白行入れる -->
                            <option value="" >----</option>
                        @foreach($ddlCandidates as $ddlitem)
                            <option value="{{$ddlitem->CdName}}" @if($item->SpeakerCd==$ddlitem->Cd) selected @endif >{{$ddlitem->CdName}}</option>
                        @endforeach
                            <option value="none" @if(is_null($item->SpeakerCd)) selected @endif>この中にない</option>
                </select>
            </div>
            <!-- 発言者 -->
            <div class="mb-2">
                <label class="form-label">発言者</label>
            </div>
            <div>
                <label>{{$item->Speaker}}</label>
            </div>
            <div>
                <x-lsuppo-input type="text" name="Speaker" value="{{old('Speaker')}}" class=""  />
                <p class="text-xs">*この中にないを選んだ時のみ有効</p>
            </div>
            <!-- 会話 -->
            <div class="mb-2">
                <label class="form-label">会話</label>
            </div>
            <div>
                <label>{{$item->Conversation}}</label>
            </div>
            <div>
                <x-lsuppo-input type="text" name="Conversation" value="{{old('Conversation')}}" class="w-full"  />
            </div>
            <!-- コメント -->
            <div class="mb-2">
                <label class="form-label">コメント</label>
            </div>
            <div>
                <label>{{$item->Comment}}</label>
            </div>
            <div>
                <x-lsuppo-input type="text" name="Comment" value="{{$item->Comment}}" class="w-full"  />
            </div>

                <div>
                    <x-lsuppo-submit :mode="'edit'" formaction="/conv/updateMeisai" class="mx-auto">更新</x-lsuppo-submit>
                </div>
            </div>
        </div>
    </form>
    <div>
        <a href="/conv/detail/?headerId={{$item->Header_id}}#id{{$item->id}}">＜一覧に戻る</a>
    </div>
</div>
@endsection