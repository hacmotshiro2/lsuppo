<?php

namespace App\Models;

class DdlItem
{
    public $Cd;
    public $Name;
    public $CdName;
    public static string $delimiter = ':';


    public function __construct(string $cd,string $name){

        $this->Cd = $cd;
        $this->Name = $name;
        $this->CdName = $cd.self::$delimiter.$name;
    }

    //CdとNameに分けて返す
    public static function separate(string $cdName){
        return explode(self::$delimiter,$cdName);
    }

}
