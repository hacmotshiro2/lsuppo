
@extends('layouts.lsuppo-base')

@section('title')
エルコイン確認ページ
@endsection
      
@section('content')
        @if ($msg !='')
        <p> {{$msg}}</p>
        @endif
        <div id=lcZandaka>
        <!-- 生徒単位のFOR分 1人の保護者に対して複数の生徒がいることを想定-->
        @for($i=0;$i<count($itemset);$i++)
            <p>ただいまの</p>
            <p><b>{{$itemset[$i][0]->StudentName}}さんの</b></p>
            <p>エルコイン残高は</p>
            <p>{{$lczandakas[$itemset[$i][0]->StudentName]}}コインです</p>
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>発生日</th>
            <th>コイン数</th>
            <th>事由</th>
            <th>事由補足</th>
        </tr>
        <!-- 生徒毎の取引明細の繰り返し -->
        @foreach($itemset[$i] as $item)
        <tr>
            <td><?=htmlspecialchars($item->HasseiDate,ENT_QUOTES)?></td> 
            <td><?=htmlspecialchars($item->amount,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->Ziyuu,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars(mb_strimwidth($item->ZiyuuHosoku,0,40," ... "),ENT_QUOTES)?></td>
        </tr>
        @endforeach
        </table>
        @endfor
        </div>
<div class="bg-white py-6 sm:py-8 lg:py-12">

  <div class="max-w-screen-lg px-4 md:px-8 mx-auto">
    <!-- 生徒単位のFOR分 1人の保護者に対して複数の生徒がいることを想定-->
    @for($i=0;$i<count($itemset);$i++)

    <div class="grid md:grid-cols-2 gap-8">
      <!-- images - start -->
      <div class="space-y-4">
        <div class="bg-gray-100 rounded-lg overflow-hidden relative">
          <img src="https://images.unsplash.com/flagged/photo-1571366992942-be878c7b10c0?auto=format&q=75&fit=crop&w=600" loading="lazy" alt="Photo by Himanshu Dewangan" class="w-full h-full object-cover object-center" />

          <span class="bg-red-500 text-white text-sm tracking-wider uppercase rounded-br-lg absolute left-0 top-0 px-3 py-1.5">sale</span>
        </div>
      </div>
      <!-- images - end -->

      <!-- content - start -->
      <div class="md:py-8">
        <!-- name - start -->
        <div class="mb-2 md:mb-3">
          <span class="inline-block text-gray-500 mb-0.5">Fancy Brand</span>
          <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold">Pullover with pattern</h2>
        </div>
        <!-- name - end -->

        <!-- price - start -->
        <div class="mb-4">
          <div class="flex items-end gap-2">
            <span class="text-gray-800 text-xl md:text-2xl font-bold">$15.00</span>
            <span class="text-red-500 line-through mb-0.5">$30.00</span>
          </div>

          <span class="text-gray-500 text-sm">incl. VAT plus shipping</span>
        </div>
        <!-- price - end -->

        <!-- description - start -->
        @foreach($itemset[$i] as $item)
        <div class="mt-10 md:mt-16 lg:mt-20">
          <div class="text-gray-800 text-lg font-semibold mb-3">Description</div>

          <p class="text-gray-500">
            This is a section of some simple filler text, also known as placeholder text. It shares some characteristics of a real written text but is random or otherwise generated. It may be used to display a sample of fonts or generate text for testing.<br /><br />

            This is a section of some simple filler text, also known as placeholder text. It shares some characteristics of a real written text but is random or otherwise generated.
          </p>
        </div>
        @endforeach
        <!-- description - end -->
      </div>
      <!-- content - end -->
    @endfor

    </div>

  </div>
</div>

@endsection