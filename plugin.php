<?php
/*
Plugin Name: Aokoke Shiki Popup
Plugin URI:
Description: 4枚の写真をいい感じにポップアップ表示する
Version: 1.0.2
Author: aokoke
Author URI:
License: GPL2

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {URI to Plugin License}.
*/


namespace Aokoke;

class PopupShiki {
  const VERSION = '1.0';
  const DATE_APPROVED = '';

  const OPTION_GROUP = 'shiki_popup_options';
  const GENERAL_SECTION = 'general_sect';
  const MESSAGE = 'message';
  const MESSAGE_SIZE = 'message_size';
  const POPUP_RADIUS = 'popup_rad';
  const REDISPLAY = 'redisp';
  const PHOTO_NUM = 4;
  
  const PHOTO_SECTION = 'photo_sect_';
  const PHOTO_IMAGE = 'photo_img_';
  const PHOTO_TITLE = 'photo_title_';
  const TITLE_SIZE = 'title_size_';

  const LINK = 'link_';
  const NEW_TAB = 'new_tab';

  const REDISP_COOKIE = 'aokoke_redisplay';
  
  private $html_result = '';    // 設定画面のhtmlは全てこの変数内に格納し、一括で出力
  
  // コンストラクタ
  function __construct() {
    // アクティベート・非アクティベート処理
    register_activation_hook(__FILE__, (function() {
      update_option(self::OPTION_GROUP, []);  // データベースにオプションを追加
    }));
    register_deactivation_hook(__FILE__, (function() {
      delete_option(self::OPTION_GROUP);      // データベースからオプションを削除
    }));
    
    $options = get_option(self::OPTION_GROUP, '');
    $redisp = self::get_safe_value($options, self::REDISPLAY);
    
    
    
    $no_popup = '';   // ポップアップ無効化フラグ（初期値：表示しない）
    
    if (is_admin()) $this->del_cookie();    // 管理ページではクッキーを削除

    if(isset($_GET['frompreviewbutton'])) { // プレビューの場合
      $this->del_cookie();                  // クッキーを削除
    } else {                                // プレビューでなければ
      
      switch($redisp) {                     // 判定を行う
        case 'once':      // 一度だけ表示
        $no_popup = $_COOKIE[self::REDISP_COOKIE];  // クッキーの値を元にポップアップ許可を指定
        $this->set_cookie();                // クッキーをセット
        break;
        case 'always':    // 常に表示
        $this->del_cookie();                // クッキーを削除
        break;
        case 'never':     // 表示しない
        $no_popup = 'yes';                  // 非表示フラグを入れる
        break;
      }
    }
    
    if(is_admin()) {    // 管理画面ならば、設定ページ表示処理を開始     
      add_action('admin_menu', [$this, 'admin_menu']);      // 管理メニュー初期化
      add_action('admin_init', [$this, 'admin_init']);      // 管理ページ初期化
    }
    else if ($no_popup !== 'yes') {    // 管理画面ではない場合、ポップアップ処理へ移行（ポップアップ許可時）
      add_action('wp_enqueue_scripts', [$this, 'popup']); // スクリプト読み込みのタイミングにフック
    }
  }
  
  function admin_menu() {  // 管理ページ項目の作成
    $hook = add_options_page(
      'ShikiPopupSettings',
      'AokokeShikiPopup',
      'administrator',
      self::OPTION_GROUP,
      [$this, 'create_admin_page']
    );
    
    // このタイミングにフックして写真読み込みスクリプトを読み込んでおく
    // 'admin_print_scripts-'.$hook　という書き方もあるらしい
    add_action('admin_print_scripts', [$this, 'admin_scripts']);
  }
  
  // 管理ページ作成
  function create_admin_page() {
    include_once('views/settings.php');
    wp_enqueue_style(self::OPTION_GROUP, plugins_url('styles/settings.css', __FILE__));
  }
  
  // 管理ページ初期設定
  function admin_init() {
    include_once('views/fields.php');
  }
  
  static function get_safe_value($options, $name, $default='') { // 各オプションを取得できる関数を定義
    return esc_attr(isset($options[$name]) ? $options[$name] : $default);
  }
  
  // 無害化処理（$inputは変更されたオプションの配列）
  function sanitize($input) {
    $result = [];
    foreach($input as $key => $value) { // 配列を回して
      $result[$key] = esc_attr($value); // 端からエスケープして放り込む
    }
    return $result;                     // 結果を返す
  }
  
  // スクリプト登録
  function admin_scripts() {
    wp_enqueue_media();   // メディアアップローダ用スクリプトの読み込み
    wp_enqueue_script(    // 独自に定義したメディア選択スクリプトの登録
      'media-selector',
      plugins_url('js/media_selector.js', __FILE__),
      ['jquery'],
      filemtime(__DIR__.'/js/media_selector.js'),
      false
    );
  }
  
  // ポップアップ処理への移行
  function popup() {
    // フロントページである場合に表示
    if (is_front_page()) {
      // Popupのcssを読み込み
      wp_register_style('aokoke_popup_style', plugins_url('popup/styles/style.css', __FILE__));
      wp_enqueue_style('aokoke_popup_style');
      
      // Popupのスクリプトを読み込み
      wp_register_script('aokoke_popup_script', plugins_url('popup/js/script.js', __FILE__));
      wp_enqueue_script('aokoke_popup_script');
      
      add_action('shutdown', function() {         // 記事の読み込み後に
        include_once(__DIR__.'/popup/popup.php'); // popup.phpファイルを参照
      });
    }
  }

  function set_cookie() {
    $cookie = $_COOKIE[self::REDISP_COOKIE];
    if (!isset($cookie) || $cookie !== 'yes')
      setcookie(self::REDISP_COOKIE, 'yes', 0, '/');
  }
  function del_cookie() {
    if (isset($_COOKIE[self::REDISP_COOKIE])) {
      setcookie(self::REDISP_COOKIE, '', time()-3600, '/');
    }
  }

}

new PopupShiki();    // クラスをインスタンス化してコンストラクタを呼び出す
