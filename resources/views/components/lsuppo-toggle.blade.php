{{-- bindChecked は checked か ""で指定する --}}
@props(['bindChecked'=>''])
@props(['description'=>''])
<label class="inline-flex relative items-center cursor-pointer">
    <input type="checkbox" value="" class="sr-only peer" disabled {{$bindChecked}}>
    <div class="w-14 h-7 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
    <span class="ml-3 text-sm font-medium text-gray-400 dark:text-gray-500">{{$description}}</span>
</label>