<div class="row g-2" >
    <div class="block sm:flex-col sm:grid sm:grid-cols-3 sm:gap-4 sm:auto-cols-fr" >
        <!-- サポーターコード -->
        <label class="text-sm sm:text-base">サポーターコード</label>
        <div class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-supporter />
        </div>
        <!-- 姓名 -->
        <label class="text-sm sm:text-base mb-2">姓・名</label>
        <x-lsuppo-input type="text" name="Sei" class="mb-2" required wire:model.debounce.500ms="Sei" maxlength="12"/>
        <x-lsuppo-input type="text" name="Mei" class="mb-2" required wire:model.debounce.500ms="Mei" maxlength="12"/>
        <!-- フリガナ -->
        <label class="text-sm sm:text-base mb-2">フリガナ</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="text" name="Hurigana" class="mb-2" required wire:model.debounce.500ms="Hurigana" maxlength="24"/>
        </div>
        <!-- 表示名 -->
        <label class="text-sm sm:text-base mb-2">表示名</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="text" name="HyouziMei" class="mb-2" required wire:model.debounce.500ms="HyouziMei" maxlength="30"/>
        </div>
        <!-- 利用開始日～終了日 -->
        <label class="text-sm sm:text-base mb-2">利用開始日～終了日</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="date" name="RiyouKaisiDate" class="mb-2" wire:model.debounce.500ms="RiyouKaisiDate" />
            <span> ～</span>
            <x-lsuppo-input type="date" name="RiyouShuuryouDate" class="mb-2" wire:model.debounce.500ms="RiyouShuuryouDate" />
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
        <!-- 権限レベル -->
        <label class="text-sm sm:text-base mb-2">権限レベル</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <x-lsuppo-input type="text" name="authlevel" class="mb-2" required wire:model.debounce.500ms="authlevel" maxlength="1"/>
        </div>
    </div>
    <!-- バリデーションルールの制御用に渡す -->
    <input type="hidden" name="mode" value="create" />
</div>
