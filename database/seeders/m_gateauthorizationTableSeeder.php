<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Consts\DBConst;

class m_gateauthorizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //
        // $params[] =[            
        //     'Path' => 'mypage',
        //     //カンマ区切りで登録する
        //     'AuthorizedGate' => 'hogosha-nobind,hogosha-binded,',
        // ];
        // $params[] =[            
        //     'Path' => 'settings',
        //     //カンマ区切りで登録する
        //     'AuthorizedGate' => 'hogosha-nobind,hogosha-binded,supporter-nobind,supporter-auth-1,supporter-auth-5,supporter-auth-9,',
        // ];


        // foreach($params as $param){


        //     $param = $param + array('UpdateGamen'=>'seeder');
        //     $param = $param + array('UpdateSystem'=>DBConst::UPDATE_SYSTEM);

        //     DB::table('m_gateAuthorization')->insert($param);
        // }

    }
}
