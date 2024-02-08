<?php
namespace App\Consts;
class DBConst
{
    const UPDATE_SYSTEM = 'lsuppo';
    const SHOUNIN_STATUS_DRAFT = 1;
    const SHOUNIN_STATUS_DELETED = 2;
    const SHOUNIN_STATUS_APPROVING = 3;
    const SHOUNIN_STATUS_RETURN = 4;
    const SHOUNIN_STATUS_APPROVED = 5;

    /* usersテーブルのnotificationTypeについて */
    const NT_MAIL = 0;
    const NT_LINE = 1;
}