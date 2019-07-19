<?php
$default = ['mes' => '春夏秋冬四季折々を青苔荘で体験してみませんか？',
            'mes_size' => '1.5',
            'link' => '',
            'new_tab' => '',
            'rad' => '0',
            'redisp' => 'never',
            'title' => ['春', '夏', '秋', '冬'],
            'ttl_size' => '3',
];

// 設定フィールド表示部
///////////////////////////////////////////////////////////////////////////////////
$option_name = $group_name = self::OPTION_GROUP;
$section_name = self::GENERAL_SECTION;
$options = get_option($group_name, []); // オプション群を取得
$get_value = 'Aokoke\PopupShiki::get_safe_value';

// オプションが保存されるように設定
register_setting($group_name, $group_name, [$this, 'sanitize']);

$this->html_result .= <<< EOM
<!-- FontAwesome読み込み -->
<script src="https://kit.fontawesome.com/f8c88b57ff.js"></script>
EOM;

// 一般セクション（開始） =============================================================================================
$this->html_result .= <<< EOM

<section class="category">
<h1><i class="fas fa-cog"></i>基本設定</h1>
EOM;

//======================================================================================
// メッセージ（＋サイズ）入力欄
$mes = self::MESSAGE;
$size = self::MESSAGE_SIZE;
$mes_value = $get_value($options, $mes, $default['mes']);
$size_value = $get_value($options, $size, $default['mes_size']);

$this->html_result .= <<< EOM
<section>
<h2>中央メッセージ</h2>
<label title="中央に表示されるメッセージです。">
<h3>テキスト（サイズ）：</h3>
<input type="text" class="wide" id="{$mes}" name="{$group_name}[{$mes}]" value="{$mes_value}"
  placeholder="ノーメッセージ。素材そのままの味を堪能できますね。">
</label>
<label>
<input type="number" name="{$group_name}[{$size}]" min="0", max="10", step="0.5" value="{$size_value}">
rem
</label>
</section>
EOM;

//========================================================================================
// クリック時の動作
$link = self::LINK;
$link_value = $get_value($options, $link, $default['link']);
$target = self::NEW_TAB;
$target_value = $get_value($options, $default['new_tab']);
$checked = checked($target_value, "1", false);

$this->html_result .= <<< EOM
<section>
<h2>リンク</h2>
<label title="ポップアップをクリックした時のリンクです。">
<h3>URL：</h3>
<input type="text" class="wide" name="{$option_name}[{$link}]" value="{$link_value}"
          placeholder="URL未設定時、ポップアップへのクリックは「閉じる」動作になります。">
</label>
<br>
<label title="チェックすると、新しいタブでリンクを開きます。">
<h3>新しいタブで開く：</h3>
<input type="checkbox" name="{$option_name}[{$target}]" value="1" "{$checked}">
</label>
</section>
EOM;

//=======================================================================================
// ポップアップの丸み付け
$name = self::POPUP_RADIUS;
$value = $get_value($options, $name, $default['rad']);

$this->html_result .= <<< EOM
<section>
<h2>ポップアップの外観</h2>
<label title="50%でまるくなります。">
<h3>丸み（％）：</h3>
<input type=number name="{$option_name}[{$name}]" min="0" max="50" step="10" value="{$value}">
%
</label>
</section>
EOM;

// // 繰り返し防止設定のチェックボックスフィールド
$name = self::REDISPLAY;
$value = $get_value($options, $name, $default['redisp']);

$once = checked($value, 'once', false);
$always = checked($value, 'always', false);
$never = checked($value, 'never', false);

$this->html_result .= <<< EOM
<section>
  <h2>その他</h2>
  <label title="ポップアップの表示頻度を選択します。">
    <h3>表示頻度</h3>
  </label>
  <label title="ブラウザを閉じるまで再表示しません。">
    <input type="radio" name="{$option_name}[{$name}]" value="once" "{$once}">
    一度だけ
  </label>
  <label title="何度でも再表示します。鬱陶しいかも……。">
    <input type="radio" name="{$option_name}[{$name}]" value="always" "{$always}">
    いつでも
  </label>
  <label title="表示しなくなります。一時的に表示したくないあなたに。">
    <input type="radio" name="{$option_name}[{$name}]" value="never" "{$never}">
    表示しない
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
<h1><i class="fas fa-camera"></i>写真情報の設定</h1>
EOM;

// ループ処理で写真の枚数に応じて項目を生成
for ($i = 0; $i < self::PHOTO_NUM; $i++) {

$title = self::PHOTO_TITLE.$i;
$title_size = self::TITLE_SIZE.$i;
$img = self::PHOTO_IMAGE.$i;

$title_val = $get_value($options, $title, $default['title'][$i]);
$size_val = $get_value($options, $title_size, $default['ttl_size']);
$img_val = $get_value($options, $img, '');

$this->html_result .= <<< EOM
<section>
<span class="thumbnail" name="{$option_name}[{$img}]"><img src="{$img_val}"></span>
<h2>写真（{$title_val}）</h2>
<label title="写真に重ねて表示されるタイトルです。">
<h3>タイトル（サイズ）：</h3>
<input type="text" name="{$option_name}[{$title}]" value="{$title_val}">
</label>
<label>
<input type="number" name="{$option_name}[{$title_size}]" min="0" step="0.5" value="{$size_val}">
rem
</label>
<br>
<label title="画像URLを入力するか、ライブラリから選択してください。">
<h3>画像URL：</h3>
<input type="text" class="wide" name="{$option_name}[{$img}]" value="{$img_val}">
<br>
<h3></h3>
<button name="select" title="{$option_name}[{$img}]">ライブラリから選択</button>
<button name="clear" title="{$option_name}[{$img}]">クリア</button>
</label>
</section>
EOM;

}

$this->html_result .= <<< EOM
</section>
EOM;
