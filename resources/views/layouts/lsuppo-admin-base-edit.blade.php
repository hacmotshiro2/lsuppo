@extends('layouts.lsuppo-base')

<!-- 必要な引数 $mode{create,update,delete} $createAction $updateAction{編集モードのAction} $deleteAction $backURL -->

@section('content')
<div >
    <div>
        <livewire:lsuppo-supermenu />
    </div>
    <div class="mx-5 p-3 mb-4 text-xs sm:text-sm rounded bg-amber-100 text-gray-800 shadow-md">
        
        @yield('description')
    </div>
    <form method="POST" action="" class="row g-2 px-5">
        @csrf
        <div>
            <!-- 各個別の編集コンポーネント -->
            @yield('editor')
        </div>
        <!-- コントロールエリア -->
        <div class="flex my-2">
            <div class="my-2">
                <a href="{{$backURL}}">
                    <input type="button" name="back" value="一覧へ戻る" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-4 py-2" >
                </a>
            </div>
            <div class="my-2 ml-4">
                @if($mode=='update')
                    <div class="flex justify-between">
                        <x-lsuppo-submit formaction="{{$updateAction}}" :mode="'edit'"  >更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="{{$deleteAction}}" :mode="'delete'" class="ml-4" >削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='delete')
                    <x-lsuppo-submit formaction="{{$deleteAction}}" :mode="'delete'" class="ml-4" >削除</x-lsuppo-submit>
                @elseif($mode=='create')
                    <x-lsuppo-submit formaction="{{$createAction}}" :mode="'add'" class="ml-4" >登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </div>
    </form>
    <!-- 参照エリア -->
    <div class="overflow-x-auto px-5">
        @yield('reference')
    </div>
</div>
@endsection

@section('pageScript')
<script>

</script>
@endsection