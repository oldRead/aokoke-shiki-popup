<?php
// 設定フィールド表示部
///////////////////////////////////////////////////////////////////////////////////
$option_name = $group_name = self::OPTION_GROUP;
$section_name = self::GENERAL_SECTION;
$options = get_option($group_name, []); // オプション群を取得
$get_value = 'Aokoke\PopupShiki::get_safe_value';

// オプションが保存されるように設定
register_setting($group_name, $group_name, [$this, 'sanitize']);

// 一般セクション（開始） =============================================================================================
$this->html_result .= <<< EOM

<section class="category">
<h1><i class="fas fa-cog fa-fw"></i>一般</h1>
EOM;

//======================================================================================
// メッセージ（＋サイズ）入力欄
$mes = self::MESSAGE;
$size = self::MESSAGE_SIZE;
$mes_value = $get_value($options, $mes, '春夏秋冬四季折々を青苔荘で体験してみませんか？');
$size_value = $get_value($options, $size, '1.5');

$this->html_result .= <<< EOM
<section>
<h2>中央メッセージ</h2>
<label title="中央に表示されるメッセージです。">
<span>テキスト（サイズ）：</span>
<input type="text" class="wide" id="{$mes}" name="{$group_name}[{$mes}]" value="{$mes_value}">
<input type="number" name="{$group_name}[{$size}]" min="0", max="10", step="0.1" value="{$size_value}">
rem
</label>
</section>
EOM;

//========================================================================================
// リンク
$link = self::LINK;
$link_value = $get_value($options, $link, '');
$target = self::NEW_TAB;
$target_value = checked($get_value($options, $target), "1", false);

$this->html_result .= <<< EOM
<section>
<h2>リンク</h2>
<label title="ポップアップをクリックした時のリンクです。">
<span>URL：</span>
<input type="text" class="wide" name="{$option_name}[{$link}]" value="{$link_value}">
</label>
<br>
<label title="チェックすると、新しいタブでリンクを開きます。">
<span>新しいタブで開く：</span>
<input type="checkbox" name="{$option_name}[{$target}]" value="1" "{$target_value}">
</label>
</section>
EOM;

//=======================================================================================
// ポップアップの丸み付け
$name = self::POPUP_RADIUS;
$value = $get_value($options, $name, 0);

$this->html_result .= <<< EOM
<section>
<h2>ポップアップの外観</h2>
<label title="50%でまるくなります。">
<span>丸み（％）：</span>
<input type=number name="{$option_name}[{$name}]" min="0" max="50" step="10" value="{$value}">
%
</label>
</section>
EOM;

// // 繰り返し防止設定のチェックボックスフィールド
$name = self::REDISPLAY;
$value = checked($get_value($options, $name), '1', false);
$this->html_result .= <<< EOM
<section>
<h2>その他</h2>
<label title="チェックすると、トップページを訪れる度に何度でも表示されます。">
<span>再表示する</span>
<input type="checkbox" name="{$option_name}[{$name}]" value="1" "{$value}">
</label>
</section>
EOM;

$this->html_result .= <<< EOM
</section>
EOM;

//===============================================================================
// 写真選択セクション
//
$this->html_result .= <<< EOM
<section class="category">
<h1><i class="fas fa-camera fa-fw"></i>写真情報の設定</h1>
EOM;

$season = ['春', '夏', '秋', '冬'];   // 初期値を番号指定できるように設定

// ループ処理で写真の枚数に応じて項目を生成
for ($i = 0; $i < self::PHOTO_NUM; $i++) {

$title = self::PHOTO_TITLE.$i;
$title_size = self::TITLE_SIZE.$i;
$img = self::PHOTO_IMAGE.$i;

$title_val = $get_value($options, $title, $season[$i]);
$size_val = $get_value($options, $title_size, '2.0');
$img_val = $get_value($options, $img);

$this->html_result .= <<< EOM
<section>
<span class="thumbnail" name="{$option_name}[{$img}]"><img src="{$img_val}"></span>
<h2>写真（{$title_val}）</h2>
<label title="写真に重ねて表示されるタイトルです。">
<span>タイトル（サイズ）：</span>
<input type="text" name="{$option_name}[{$title}]" value="{$title_val}">
<input type="number" name="{$option_name}[{$title_size}]" value="{$size_val}">
rem
</label>
<br>
<label title="画像URLを入力するか、ライブラリから選択してください。">
<span>画像URL：</span>
<input type="text" class="wide" name="{$option_name}[{$img}]" value="{$img_val}">
<br>
<span></span>
<button name="select" title="{$option_name}[{$img}]">ライブラリから選択</button>
<button name="clear" title="{$option_name}[{$img}]">クリア</button>
</label>
</section>
EOM;

}

$this->html_result .= <<< EOM
</section>
EOM;
