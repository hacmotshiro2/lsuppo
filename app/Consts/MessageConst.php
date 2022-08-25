<?php
namespace App\Consts;
#TODO このクラス自体要らないかも
class MessageConst
{
    const U2H_ERROR = 'ログイン情報と保護者情報の紐づけを管理者が行う必要があります。';
    const NOT_BINDED = '登録後、管理者による確認作業が済むまでフィードバック等の機能をご覧いただくことができません。';
    const ADD_COMPLETED = '正しく追加登録されました。';
    const EDIT_COMPLETED = '正しく更新登録されました。';
}