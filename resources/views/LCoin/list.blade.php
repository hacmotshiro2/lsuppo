
@extends('layouts.lsuppo-base')

@section('title')
エルコイン登録明細
@endsection
      
@section('content')

<div class="bg-white py-2 sm:py-8 lg:py-12">
  <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
    <!-- <div class="grid gap-8 mb-8"> -->
    <div class="container px-5 py-2 mx-auto">
      <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
          <a href="/lc/add" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
          <a href="/lc/addnoab" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録（単独）</a>
      </div>
    </div>
    <div>
      <livewire:lcoin-list/>
    </div>
      <!-- description - start -->
        <div class="w-full mt-6 md:mt-8">
          <span class="text-gray-600 text-lg font-semibold mb-3">コイン明細</span>
          <table class="table-fixed">
            <tr>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">生徒</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">発生日</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">コイン数</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">事由</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">事由補足</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">登録サポーターコード</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">更新日</th>
                <th class="bg-gray-300 text-slate-50 px-2 py-2">Action</th>
            </tr>
            @foreach($items as $item)
            <!-- <tr class="hover:bg-gray-400"> -->
            <tr class="">
                <td class="px-2 py-2">{{$item->StudentCd}}</td>
                <td class="px-2 py-2">{{$item->HasseiDate}}</td>
                <td class="px-2 py-2">{{$item->Amount}}</td>
                <td class="px-2 py-2">{{$item->ZiyuuCd}}</td>
                <td class="px-2 py-2">{{$item->ZiyuuHosoku}}</td>
                <td class="px-2 py-2">{{$item->TourokuSupporterCd}}</td>
                <td class="px-2 py-2">{{$item->updated_at}}</td>
                <td class="px-2 py-2"><form id="formLCDelete" action="/lc/delete" method="POST" onsubmit="return onDelete()">
                  @csrf
                  <input type="hidden" name="id" value="{{$item->id}}" >
                  <button id="btnDelete" name="delete" type="submit" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3" >削除</button>
                  </form>
                </td>
                
            </tr>
            @endforeach
          </table>
        </div>
        <!-- description - end -->
      <!-- </div> -->
      <!-- content - end -->

    </div>
  </div>
</div>

@endsection