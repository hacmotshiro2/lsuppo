<div class="block">
    <table class="table w-full text-left min-w-full shadow-md">
        <thead class="text-xs md:text-base text-gray-600 bg-gray-50">
            <tr>
                <th class="p-2 border border-slate-600">SupporterCd</th>
                <th class="p-2 border border-slate-600">Sei</th>
                <th class="p-2 border border-slate-600">Mei</th>
                <th class="p-2 border border-slate-600">Hurigana</th>
                <th class="p-2 border border-slate-600">HyouziMei</th>
                <th class="p-2 border border-slate-600">RiyouKaisiDate</th>
                <th class="p-2 border border-slate-600">RiyouShuuryouDate</th>
                <th class="p-2 border border-slate-600">LearningRoomCd</th>
                <th class="p-2 border border-slate-600">authlevel</th>
                <th class="p-2 border border-slate-600">IsLocked</th>
                <th class="p-2 border border-slate-600">IsNeedPWChange</th>
                <th class="p-2 border border-slate-600">Action</th>
            </tr>
        </thead>
        <tbody class="text-sm md:text-base text-gray-700">
            @foreach($items as $item)
            <tr>
                <td class="p-2 border border-slate-700">{{$item->SupporterCd}}</td>
                <td class="p-2 border border-slate-700">{{$item->Sei}}</td>
                <td class="p-2 border border-slate-700">{{$item->Mei}}</td>
                <td class="p-2 border border-slate-700">{{$item->Hurigana}}</td>
                <td class="p-2 border border-slate-700">{{$item->HyouziMei}}</td>
                <td class="p-2 border border-slate-700">{{$item->RiyouKaisiDate}}</td>
                <td class="p-2 border border-slate-700">{{$item->RiyouShuuryouDate}}</td>
                <td class="p-2 border border-slate-700">{{$item->LearningRoomCd}}</td>
                <td class="p-2 border border-slate-700">{{$item->authlevel}}</td>
                <td class="p-2 border border-slate-700">{{$item->IsLocked}}</td>
                <td class="p-2 border border-slate-700">{{$item->IsNeedPWChange}}</td>
                <!-- <td class="border border-slate-700"><a href="/user2hogosha/delete/?u2h_id={{$item->u2h_id}}"><div class="inline-block items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"> 紐づけ削除</div></td> -->
                <td class="p-2 border border-slate-700">
                    @if($item->SupporterCd)
                    <a href="/supporter/edit/?supporterCd={{$item->SupporterCd}}">
                        <input type="button" name="back" value="編集" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-2" >
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
