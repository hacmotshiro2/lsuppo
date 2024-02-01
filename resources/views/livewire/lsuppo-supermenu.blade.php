<div class="bg-emerald-100 rounded border-y-lime-700 relative my-8">
    <button class="w-full" wire:click="toggleMenu">管理者メニュー　　{!! $icOpenClose !!}</button>
    @if($isMenuOpen)
    <ul class="list-decimal m-8">
        <!-- <li><a href="/lr/add/">ラーニングルーム登録</a></li> -->
        <li class="pl-4">ラーニングルーム登録</li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/hogosha/list/">保護者登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/student/list/">生徒登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/user2hogosha/list/">ユーザーと保護者の紐づけ登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/supporter/list/">サポーター登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/user2suppo/list/">ユーザーとサポーターの紐づけ登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/absence/list_sp/">欠席情報登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/lc/list/">エルコイン登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/lcziyuu/add/">エルコイン事由マスタメンテ</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/conv/upload/">CLOVAアップロード</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/conv/">登録済みCLOVA一覧</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/mv/presen/add/">発表動画登録</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/mv/presen/all/">発表動画一覧</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/signinhistory/index/">サインイン履歴一覧</a></li>
        <li class="hover:bg-emerald-200 rounded pl-4"><a href="/cp/add/">コース・プラン登録</a></li>
    </ul>
    @endif
</div>
