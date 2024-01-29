<div>
    <!-- 当コントロールの外側との距離感はここに書かず、親側で指定する。 -->
    <!-- つまり、当コントロールの一番上のdivには margin を書かない -->
    <!-- ref:https://makitweb.com/make-live-autocomplete-search-with-livewire-in-laravel/ -->
    <div class="sm:flex ">
        <div>
            <x-lsuppo-input type='text' name="user_id" wire:model.debounce.10ms="search" wire:keyup="searchResult" placeholder="名前で検索できます" :readonly="$isRO"></x-lsuppo-input>
        </div>
        @if(!empty($details))
            <div class="inline-block  align-middle ">
                <span class="ml-2 h-full align-middle text-base">
                    Name : {{ $details->name }}
                </span>
            </div>
        @endif
    </div>
    <!-- Search result list -->
    @if($showresult)
    <div class="absolute border-2 rounded">
        <ul class="w-96 bg-gray-50 drop-shadow-lg">
            @if(!empty($records))
                @foreach($records as $record)
                    <li class="p-2 text-base hover:bg-gray-400 hover:text-white" wire:click="fetchDetail({{ $record->id }})">{{ $record->name}} , {{ $record->UserTypeName }} , {{ $record->studentName}}</li>
                @endforeach
            @endif
        </ul>
    </div>
    @endif
    <!-- end result list -->
</div>

