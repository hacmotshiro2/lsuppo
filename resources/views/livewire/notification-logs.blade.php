<div class="container">
  <div class="relative overflow-x-auto shadow-md rounded ">
    {{ $items->links() }}
    <table class="table w-full text-sm text-left text-gray-600 min-w-full mt-2">
        <thead class="text-xs text-gray-700 bg-gray-100">
            <tr>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('id')">id {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('user_id')">user_id {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4" >name</th>
                <th class="border border-slate-600 p-4" >email</th>
                <th class="border border-slate-600 p-4" >line_user_id</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('notification_type')">notification_type {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('notification_class')">notification_class {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('channel')">channel {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('created_at')">created_at {!! $sortLink !!}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="border border-slate-700 p-2">{{$item->id}}</td>
                <td class="border border-slate-700 p-2">{{$item->user_id}}</td>
                <td class="border border-slate-700 p-2">{{$item->name}}</td>
                <td class="border border-slate-700 p-2">{{$item->email}}</td>
                <td class="border border-slate-700 p-2">{{$item->line_user_id}}</td>
                <td class="border border-slate-700 p-2">{{$item->NTCodeName}}</td>
                <td class="border border-slate-700 p-2">{{$item->notification_class}}</td>
                <td class="border border-slate-700 p-2">{{$item->channel}}</td>
                <td class="border border-slate-700 p-2">{{$item->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
  </div>
</div>