@extends('layouts.lsuppo-base')

@section('content')
<div>
    <div>
        <livewire:lsuppo-supermenu />
    </div>
    <div class="px-5">
        <div class="overflow-x-auto">
            @yield('list')
        </div>
    </div>
</div>
@endsection
