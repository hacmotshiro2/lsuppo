
@extends('layouts.lsuppo-base')

@section('title')
LC事由マスタメンテ
@endsection
      
@section('content')
<div class="flex flex-wrap md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="#" class="row g-2">
            @csrf
            <div class="mb-2">
                <label for="ZiyuuCd" class="form-label">事由コード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="ZiyuuCd" name="ZiyuuCd" value="{{$item->ZiyuuCd}}" class="form-control bg-gray-200" required maxlength="3" readonly />
                @else
                    <x-lsuppo-input type="text" id="ZiyuuCd" name="ZiyuuCd" value="{{old('ZiyuuCd')}}" class="bg-white" required maxlength="3" />
                @endif
            </div>
            <div class="mb-2">
                <label for="Ziyuu" class="form-label">事由</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="Ziyuu" name="Ziyuu" value="{{$item->Ziyuu}}" class="form-control" required maxlength="40" />
                @else
                    <x-lsuppo-input type="text" id="Ziyuu" name="Ziyuu" value="{{old('Ziyuu')}}" class="form-control" required maxlength="40" />
                @endif
            </div>
            <div class="mb-2">
                <label for="DefaultAmount" class="form-label">デフォルト値</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="number" id="DefaultAmount" name="DefaultAmount" value="{{$item->DefaultAmount}}" class="form-control" required max="9999"/>
                @else
                    <x-lsuppo-input type="number" id="DefaultAmount" name="DefaultAmount" value="{{old('DefaultAmount')}}" class="form-control" required min="-9999"/>
                @endif
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">説明</label>
                @if($mode=='edit')
                    <textarea name="description" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" >{{$item->description}}</textarea>
                @else
                    <textarea name="description" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" >{{old('description')}}</textarea>
                @endif
            </div>
            <div class="mb-2">
                @if($mode=='edit')
                    <div class="flex justify-between">
                        <x-lsuppo-submit formaction="/lcziyuu/edit" :mode="'edit'">更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="/lcziyuu/delete" :mode="'delete'">削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='add')
                    <x-lsuppo-submit formaction="/lcziyuu/create" :mode="'add'">登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </form>
        <div id='list'>
            <table class="table table-striped table table-hover table table-responsive">       
                <tr>
                    <th>ZiyuuCd</th>
                    <th>Ziyuu</th>
                    <th>DefaultAmount</th>
                    <th>description</th>
                    <th>updated_at</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td><a href="/lcziyuu/add/?ZiyuuCd={{$item->ZiyuuCd}}" class="text-indigo-700">{{$item->ZiyuuCd}}</a></td>
                    <td>{{$item->Ziyuu}}</td>
                    <td>{{$item->DefaultAmount}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->updated_at}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection