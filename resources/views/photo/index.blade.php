@extends('layouts.lsuppo-base')

@section('title')
フォトアルバム閲覧ページ
@endsection

@section('pageCSS')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/photo-index.css" >
@endsection

@section('pageScript')
<script type="text/javascript">
    function copy(link) {
        const text =document.getElementById(link);
        text.select();
        document.execCommand("copy");
    }
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
@endsection      


{{-- ref https://coco-factory.jp/ugokuweb/move01/6-2-1/ --}}
@section('content')
<section class="text-gray-600 body-font overflow-hidden">
  <!-- コンテンツ -->
  {{-- <div class="row mx-0 pt-0 pb-3 align-items-center">
    <label for="width" class="my-0">Width:</label>
    <input type="number" step="120" min="0" id="width" class="form-control form-control-sm mx-2 my-0" style="width: 120px;" placeholder="Number" @if(!empty($width))value={{$width}} @endif>
    <label for="md" class="mx-2 my-0">Markdown:</label>
  </div> --}}
  
  <div class="">
    <ul class="gallery">
    {{-- <%for(let link of links){%> --}}
    @foreach($links as $link)
      <li>
        <a href="{{$link}}" data-lightbox="gallery1" data-title="">
          <img src="{{$link}}=w1024">
        </a>
        {{-- <div class="photo-card col-span-6 md:col-span-4 lg:col-span-3 px-0"> --}}
          {{-- <div class="img-box" onclick="copy('<%=link%>')"> --}}
          {{-- <div class="img-box" onclick="copy('{{$link}}')">
            <img src="{{$link}}=w240">
          </div> --}}
          {{-- <div class="form-row">
            <div class="col pr-0">
              <input type="text" class="form-control copy-val" value="{{$link}}" id="{{$link}}">
            </div>
            <div class="col-auto pl-0">
              <button class="btn btn-outline-dark copy-btn" onclick="copy('{{$link}}')">Copy!</button>
            </div>
          </div> --}}
        {{-- </div> --}}
      </li>
    @endforeach
    {{-- <%}%> --}}
    </ul>
  </div>
  <div>
    <label class="block text-gray-700 text-sm sm:text-base my-2 md:my-4">HPには掲載していない写真も含めて掲載しています。保護者の方およびサポーターしか見ることができませんので、ご安心ください。</label>
  </div>
</section>

@endsection

