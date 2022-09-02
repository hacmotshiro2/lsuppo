<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class m_lc_ziyuuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $param =[
            'ZiyuuCd' => '10',
            'Ziyuu' => '事前通知欠席',
            'DefaultAmount'=>'20',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_lc_ziyuu')->insert($param);

        //
        $param =[
            'ZiyuuCd' => '20',
            'Ziyuu' => '直前欠席',
            'DefaultAmount'=>'10',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_lc_ziyuu')->insert($param);
        
    }
}
