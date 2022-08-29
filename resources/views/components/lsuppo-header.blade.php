<!-- 初期値セット -->
@props(['userName' => 'ななしさん'])

<header class="container mx-auto text-white pb-1">
    <div class="flex justify-between bg-gray-300 items-center fixed md:static w-full h-16">
        <div id="headerLogo" class="mx-8">
            <a href="/"><img class="bg-gray-300 h-16" src="/images/logo-lsuppov1.0-bgw-wide.svg"></a>
        </div>
        <div class="mx-4">
            <!-- 768px以上でハンバーガーメニュー非表示に -->
            <button class="md:hidden focus:outline-none" @click="isOpen = !isOpen">
                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path v-show="!isOpen" d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
                    <path v-show="isOpen" d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
                </svg>
            </button>
        </div>
    </div>
    <div :class="isOpen ? 'block' : 'hidden'" class="fixed md:static w-full mt-16 md:mt-0 bg-gray-300 md:block">
        <div align="right" class="mx-8">
            @unless(@empty($userName))
            <p>{{$userName}}さん</p>
            @endunless
        </div>
        <div >
            <ul class="md:flex justify-end">
                <!-- 生徒紐づけて完了している保護者 -->
                @can('hogosha-binded')
                <li class="border-b-2 md:border-none"><a href="/mypage/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">ホーム</a></li>
                <li class="border-b-2 md:border-none"><a href="/fb/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">フィードバック</a></li>
                <li class="border-b-2 md:border-none"><a href="/lc/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">エルコイン</a></li>
                <!-- 生徒紐づけが完了していない保護者 -->
                @elsecan('hogosha-nobind')
                <li class="border-b-2 md:border-none"><a href="/mypage/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">ホーム</a></li>
                <!-- サポーターマスタとの紐づけが完了しているサポーター -->
                @elsecan('supporter-binded')
                <li class="border-b-2 md:border-none"><a href="/supporter-page/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">ホーム</a></li>
                <li class="border-b-2 md:border-none"><a href="/fb/index_sp" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">フィードバック</a></li>
                <!-- サポーターマスタとの紐づけが完了していないサポーター -->
                @elsecan('supporter-nobind')
                <li class="border-b-2 md:border-none"><a href="/supporter-page/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">ホーム</a></li>
                <!-- その他 -->
                @else
                @endcan
                <li class="border-b-2 md:border-none"><a href="/settings/" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded">設定</a></li>
                <li><form method="POST" action="{{ route('logout') }}">
                            @csrf<a href="{{ route('logout') }}" class="block px-8 py-2 my-4 hover:bg-gray-600  rounded" onclick="event.preventDefault();
                                                this.closest('form').submit();">ログアウト</a>
                        </form>
                </li>
            </ul>
        </div>
    </div>
</header>
