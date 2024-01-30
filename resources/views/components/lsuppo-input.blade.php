@props(['disabled' => false])
@props(['readonly' => false])
<input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => 'form-control bg-white text-gray-800 border rounded-md shadow-sm border-gray-300 forcus:bg-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 
    disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' ]) !!} >