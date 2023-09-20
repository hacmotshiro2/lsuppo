
@extends('layouts.lsuppo-base')

@section('title')
エルコイン登録ページ
@endsection
      
@section('content')
<div class="mx-2 md:mx-4">
    <livewire:lcoin-regist />
</div>

@endsection
@section('pageScript')
<script>
    document.addEventListener('DOMContentLoaded',function(){
        var el = document.getElementById('ZiyuuCd');
        el.addEventListener('change', function(){
            //変更されたら
            // console.log('変更された');
            var i = el.selectedIndex;
            // console.log(i);
            var dAmount =  el.options[i].getAttribute('data-da');

            var txt = document.getElementById('txtAmount');
            if(txt.value === ''){
                // console.log('テキストの値は空です');
                // console.log(dAmount);
                //空の場合に、初期値をセットする
                txt.value = dAmount;
            }
        });

        //#TODO 選択ボタンがクリックされて、選択中のIDが変わったら、選択された行のボタンのCLASS（見た目）を変更する
        Livewire.hook('element.updated', (el, component) => {});

    });
</script>
@endsection