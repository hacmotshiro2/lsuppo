<div class="row g-2" >
    <div class="block sm:flex-col sm:grid sm:grid-cols-3 sm:gap-4 sm:auto-cols-fr" >
        <!-- 保護者コード -->
        <label class="text-sm sm:text-base">保護者コード</label>
        <div class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-hogosha />
        </div>
        <!-- 姓名 -->
        <label class="text-sm sm:text-base mb-2">姓・名</label>
        <x-lsuppo-input type="text" name="Sei" class="mb-2" required wire:model.debounce.10ms="Sei" />
        <x-lsuppo-input type="text" name="Mei" class="mb-2" required wire:model.debounce.10ms="Mei" />
        <!-- フリガナ -->
        <label class="text-sm sm:text-base mb-2">フリガナ</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="text" name="Hurigana" class="mb-2" required wire:model.debounce.10ms="Hurigana" />
        </div>
        <!-- 利用開始日～終了日 -->
        <label class="text-sm sm:text-base mb-2">利用開始日～終了日</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="date" name="RiyouKaisiDate" class="mb-2" wire:model.debounce.10ms="RiyouKaisiDate" />
            <span> ～</span>
            <x-lsuppo-input type="date" name="RiyouShuuryouDate" class="mb-2" wire:model.debounce.10ms="RiyouShuuryouDate" />
        </div>
        <!-- LearningRoomCd -->
        <label class="text-sm sm:text-base mb-2">LRコード</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <select class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="LearningRoomCd">
                @foreach($lrs as $lr)
                <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- バリデーションルールの制御用に渡す -->
    <input type="hidden" name="mode" value="create" />
</div>
