<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LRTableSeeder extends Seeder
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
            'LearningRoomCd' => '100001',
            'LearningRoomName' => '玉造本校',
            'UpdateGamen' => 'seeder',
            'UpdateSystem' => 'lsuppo',
        ];

        DB::table('m_learningroom')->insert($param);
    }
}
