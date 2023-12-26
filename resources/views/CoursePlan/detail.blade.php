
@extends('layouts.lsuppo-base')

@section('title')
コース・プラン詳細
@endsection
      
@section('content')
<div class="container">
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
      <p class="mb-2 text-center font-semibold text-indigo-500 md:mb-3 lg:text-lg">Course/Plan</p>

      <h2 class="mb-4 text-center text-2xl font-bold text-gray-800 md:mb-6 lg:text-3xl">コース・プラン</h2>

      <p class="mx-auto max-w-screen-md text-center text-gray-500 md:text-lg">コース・プラン変更ご希望の際はサポーターにご連絡ください</p>
    </div>
  </div>
  <div>
      <livewire:courseplan-detail />
  </div>
</div>


@endsection
@section('pageScript')
<script>
</script>
@endsection