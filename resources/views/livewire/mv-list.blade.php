<div class="block">
    <table class="table w-full text-left min-w-full shadow-md">
        <thead class="text-xs md:text-base text-gray-600 bg-gray-50">
            <tr>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('id')">id {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('StudentCd')">StudentCd {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4">StudentName</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ShootingDate')">ShootingDate {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4">Title</th>
                <th class="border border-slate-600 p-4">Description</th>
                <th class="border border-slate-600 p-4">YouTubeId</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('created_at')">created_at {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('updated_at')">created_at {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4">Action</th>
            </tr>
        </thead>
        <tbody class="text-sm md:text-base text-gray-700">
            @foreach($items as $item)
            <tr>
                <td class="border border-slate-700 p-2">{{$item->id}}</td>
                <td class="border border-slate-700 p-2"><a href="/mv/presen/index_student?studentCd={{$item->StudentCd}}" class="hover:text-indigo-800 underline underline-offset-2">{{$item->StudentCd}}</a></td>
                <td class="border border-slate-700 p-2">{{$item->StudentName}}</td>
                <td class="border border-slate-700 p-2">{{$item->ShootingDate}}</td>
                <td class="border border-slate-700 p-2">{{$item->Title}}</td>
                <td class="border border-slate-700 p-2">{{mb_strimwidth($item->Description,0,30,"...")}}</td>
                <td class="border border-slate-700 p-2">{{$item->YouTubeId}}</td>
                <td class="border border-slate-700 p-2">{{$item->created_at}}</td>
                <td class="border border-slate-700 p-2">{{$item->updated_at}}</td>
                <td class="border border-slate-700 p-2">
                    @if($item->id)
                    <a href="/mv/presen/edit?id={{$item->id}}">
                        <input type="button" name="back" value="編集" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-2" >
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
