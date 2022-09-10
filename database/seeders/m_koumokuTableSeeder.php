<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


class m_koumokuTableSeeder extends Seeder
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
            'Shubetu' => 100,
            'Code' => '1',
            'Value'=>'下書き中',
            'Hosoku'=>'',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_koumoku')->insert($param);

        //
        $param =[
            'Shubetu' => 100,
            'Code' => '2',
            'Value'=>'削除済み',
            'Hosoku'=>'',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_koumoku')->insert($param);
        //
        $param =[
            'Shubetu' => 100,
            'Code' => '3',
            'Value'=>'承認中',
            'Hosoku'=>'',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_koumoku')->insert($param);
        //
        $param =[
            'Shubetu' => 100,
            'Code' => '4',
            'Value'=>'差し戻し',
            'Hosoku'=>'',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_koumoku')->insert($param);
        //
        $param =[
            'Shubetu' => 100,
            'Code' => '5',
            'Value'=>'承認済み',
            'Hosoku'=>'',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_koumoku')->insert($param);
        

    }
}
