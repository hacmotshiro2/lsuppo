<div class="row g-2" >
    <div class="block sm:flex-col sm:grid sm:grid-cols-3 sm:gap-4 sm:auto-cols-fr" >
        <!-- ユーザー情報 -->
        <label class="text-sm sm:text-base">user_id</label>
        <div class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-user :isRO="false"/>
        </div>
        <!-- 保護者情報 -->
        <label class="text-sm sm:text-base">保護者コード</label>
        <div  class="sm:col-span-2 mb-2 sm:mb-0">
            <livewire:lsuppo-sb-hogosha />
        </div>
    </div>
</div>
