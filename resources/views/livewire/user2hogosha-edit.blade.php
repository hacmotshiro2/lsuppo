<div class="row g-2" >
    <div class="block sm:flex-col sm:grid sm:grid-cols-3 sm:gap-4 sm:auto-cols-fr" >
        <!-- ユーザー情報 -->
        <label class="text-sm sm:text-base">user_id</label>
        <div class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-user :isRO="true" :defaultValue="$user_id"/>
        </div>
        <!-- 保護者情報 -->
        <label class="text-sm sm:text-base">保護者コード</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-hogosha  :defaultValue="$HogoshaCd"/>
        </div>
        <input type="hidden" name="u2h_id" value="{{$u2h_id}}" />
    </div>
</div>
