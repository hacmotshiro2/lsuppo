<?php
namespace App\Consts;
#TODO このクラス自体要らないかも
class MessageConst
{
    const U2H_ERROR = 'ログイン情報と保護者情報の紐づけを管理者が行う必要があります。';
    const NOT_BINDED = '登録後、管理者による確認作業が済むまでフィードバック等の機能をご覧いただくことができません。';
    const ADD_COMPLETED = '正しく追加登録されました。';
    const EDIT_COMPLETED = '正しく更新登録されました。';
    const DELETE_COMPLETED = '正しく削除されました。';
    const REQUIRED = '%1$sは必ず入力してください';
    const NUMERIC = '%1$sを整数で入力してください';
    const BEFORE = '%1$sには%2$s以前の日付を入力してください';
    const AFTER = '%1$sには%2$s以降の日付を入力してください';
    const APPLOVED = '承認が完了しました。';
    const DECLINED = '差し戻しました。';
    const DENIED_EDIT = '編集権限がありません。';
    const SHOUNIN_STATUS_ERROR = '承認ステータスエラー　編集可能な状態ではありません。';
    const UPLOAD_COMPLETED = 'アップロードが完了しました。';
    const SPEAKER_EDITED = '発言者を更新しました';
    const IS_DISABLED = '利用可能期間外です。詳しくはサポーターにお問い合わせ下さい。';
}