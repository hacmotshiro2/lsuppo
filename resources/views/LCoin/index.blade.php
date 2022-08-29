
@extends('layouts.lsuppo-base')

@section('title')
エルコイン確認ページ
@endsection
      
@section('content')

<div class="bg-white py-2 sm:py-8 lg:py-12">

  <div class="max-w-screen-lg px-4 md:px-8 mx-auto">
    <!-- 生徒単位のFOR分 1人の保護者に対して複数の生徒がいることを想定-->
    @for($i=0;$i<count($itemset);$i++)

    <div class="grid md:grid-cols-2 gap-8 mb-8">
      <!-- images - start -->
      <div class="space-y-1">
        <!-- <div class="bg-gray-100 rounded-lg overflow-hidden relative"> -->
        <div class="bg-gray-100 rounded-lg overflow-hidden xl:w-2/3 h-60 lg:h-auto bg-gray-100 overflow-hidden shadow-lg">
          <!-- <img src="https://images.unsplash.com/flagged/photo-1571366992942-be878c7b10c0?auto=format&q=75&fit=crop&w=600" loading="lazy" alt="Photo by Himanshu Dewangan" class="w-full h-full object-cover object-center" /> -->
          <img src="/images/lcoin_mainimage.gif" loading="lazy" alt="エルコイン" class="w-full h-full object-cover object-center" />
        </div>
      </div>
      <!-- images - end -->

      <!-- content - start -->
      <div class="md:py-8">
        <!-- name - start -->
        <div class="mb-2 md:mb-3">
          <span class="inline-block text-gray-600 mb-0.5">エルコイン残高</span>
          <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold">{{$itemset[$i][0]->StudentName}}さん</h2>
        </div>
        <!-- name - end -->

        <!-- price - start -->
        <div class="mb-4">
          <div class="flex items-end gap-2">
            <span class="text-gray-800 text-xl md:text-4xl font-bold">{{$lczandakas[$itemset[$i][0]->StudentName]}}コインです</span>
          </div>
        </div>
        <!-- price - end -->

        <!-- description - start -->
        <div class="mt-6 md:mt-8 lg:mt-20">
          <span class="text-gray-600 text-lg font-semibold mb-3">コイン明細</span>
          <table class="table-fixed text-base">
            <tr>
                <th class="w-2/9 bg-gray-300 text-slate-50 px-2 py-2">発生日</th>
                <th class="w-2/9 bg-gray-300 text-slate-50 px-2 py-2">コイン数</th>
                <th class="w-2/9 bg-gray-300 text-slate-50 px-2 py-2">事由</th>
                <th class="w-1/3 bg-gray-300 text-slate-50 px-2 py-2">事由補足</th>
            </tr>
            @foreach($itemset[$i] as $item)
            <!-- <tr class="hover:bg-gray-400"> -->
            <tr class="">
                <td class="px-2 py-2">{{$item->HasseiDate}}</td>
                <td class="px-2 py-2">{{$item->amount}}</td>
                <td class="px-2 py-2">{{$item->Ziyuu}}</td>
                <td class="px-2 py-2">{{$item->ZiyuuHosoku}}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- description - end -->
      </div>
      <!-- content - end -->

    </div>
    @endfor

  </div>
</div>

@endsection