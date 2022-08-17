<?php
namespace App\Consts;

class AuthConst
{
    const USER_TYPE_HOGOSHA = '1';
    const USER_TYPE_STUDENT = '2';
    const USER_TYPE_SUPPORTER = '3';
    const USER_TYPE_SYSAD = '9';
    const USER_TYPE_LIST = [
        '保護者'=> self::USER_TYPE_HOGOSHA,
        '子ども'=> self::USER_TYPE_STUDENT,
        'サポーター'=>self::USER_TYPE_SUPPORTER,
        'システム管理者'=>self::USER_TYPE_SYSAD,
    ];

}