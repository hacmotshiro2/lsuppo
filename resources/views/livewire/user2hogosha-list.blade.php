<div class="block">
    <table class="table w-full text-left min-w-full shadow-md">
        <thead class="text-xs md:text-base text-gray-600 bg-gray-50">
            <tr>
                <th class="p-2 border border-slate-600">[user]<br/>id</th>
                <th class="p-2 border border-slate-600">[user]<br/>name</th>
                <th class="p-2 border border-slate-600">[user]<br/>email</th>
                <th class="p-2 border border-slate-600">[user]<br/>userType</th>
                <th class="p-2 border border-slate-600">[user]<br/>StudentName</th>
                <th class="p-2 border border-slate-600">[user2hogosha]<br/>user_id</th>
                <th class="p-2 border border-slate-600">[user2hogosha]<br/>HogoshaCd</th>
                <th class="p-2 border border-slate-600">action</th>
            </tr>
        </thead>
        <tbody class="text-sm md:text-base text-gray-700">
            @foreach($items as $item)
            <tr>
                <td class="p-2 border border-slate-700">{{$item->id}}</td>
                <td class="p-2 border border-slate-700">{{$item->name}}</td>
                <td class="p-2 border border-slate-700">{{$item->email}}</td>
                <td class="p-2 border border-slate-700">{{$item->userType}}</td>
                <td class="p-2 border border-slate-700">{{$item->StudentName}}</td>
                <td class="p-2 border border-slate-700">{{$item->user_id}}</td>
                <td class="p-2 border border-slate-700">{{$item->HogoshaCd}}</td>
                <!-- <td class="border border-slate-700"><a href="/user2hogosha/delete/?u2h_id={{$item->u2h_id}}"><div class="inline-block items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"> 紐づけ削除</div></td> -->
                <td class="p-2 border border-slate-700">
                    @if($item->user_id)
                    <a href="/user2hogosha/edit/?u2h_id={{$item->u2h_id}}">
                        <input type="button" name="back" value="編集" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-2" >
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
