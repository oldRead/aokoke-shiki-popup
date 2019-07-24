<?php
// cssとして扱われるよう定義
header('Content-Type: text/css; carset=utf-8');

// wp関数の使用に必須
include_once(dirname(__FILE__).'/../../../../../wp-load.php');

$opt_message_size = Aokoke\PopupShiki::MESSAGE_SIZE;
$opt_title_size = Aokoke\PopupShiki::TITLE_SIZE;
$opt_radius = Aokoke\PopupShiki::POPUP_RADIUS;

$options = get_option(Aokoke\PopupShiki::OPTION_GROUP, '');
if ($options === '') return;    // オプションがなければ終了

$get_value = 'Aokoke\PopupShiki::get_safe_value'; // オプションを取得するメソッド

$message_size = $get_value($options, $opt_message_size, '1.5').'rem';
$title_size = $get_value($options, $opt_title_size, '2.0').'rem';
$radius = $get_value($options, $opt_radius, '0').'%';

?>

.aokoke_popup p {
  margin: 0;
}

.aokoke_popup .gallery {
  width: 100%;
  height: 100%;
  margin: 0;
}

.aokoke_popup figcaption {
  z-index: 2;
  position: absolute;
  width: 80%;
  top: 20%;
  bottom: 20%;
}

.aokoke_popup figcaption p {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  margin: auto;
  color: white;
  background-color: #ffffff55;
  border-radius: 50%;
  word-wrap: normal;
  font-size: <?= $message_size ?>;
  margin-top: <?= '-'.$message_size ?>;
  line-height: <?= $message_size ?>;
}

.aokoke_popup .photo {
  position: absolute;
  width: 50%;
  height: 50%;

  overflow: hidden;
}

.aokoke_popup .photo.top {
  top: 0;
}

.aokoke_popup .photo.bottom {
  bottom: 0;
}

.aokoke_popup .photo.left {
  left: 0;
}

.aokoke_popup .photo.right {
  right: 0;
}

.aokoke_popup section p {
  z-index: 1;
  position: absolute;
  color: white;
  opacity: 0.7;
  top: 1rem;
  font-weight: bolder;
  font-size: <?= $title_size ?>;
}

.aokoke_popup .left p {
  left: 1rem;
}
.aokoke_popup .right p {
  right: 1rem;
}

.aokoke_popup img {
  z-index: -1;
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.aokoke_popup {
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  line-height: 100vh;
  text-align: center;
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
}

.aokoke_popup.is_show {
  opacity: 1;
  visibility: visible;
  transition: 1s;
}

.aokoke_popup.is_hidden {
  transition: .8s;
}

.aokoke_popup .popup_inner {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;
  background-color: white;
  line-height: 80%;
  height: 90%;
  width: 70%;
  z-index: 2;
  overflow: hidden;
  vertical-align: middle;
  text-align: center;
  border-radius: <?= $radius ?>;
}

.aokoke_popup .close_btn {
  position: absolute;
  right: 0;
  left: 0;
  top: 0;
  margin: auto;
  width: 50px;
  height: 50px;
  line-height: 50px;
  text-align: center;
  cursor: pointer;
  z-index: 10;
  color: white;
}

.aokoke_popup .close_btn i {
  font-size: 2rem;
  color: white;
}

.aokoke_popup .black_background {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,.8);
  z-index: 1;
  cursor: pointer;
  transition: .6s;
}

.aokoke_popup .icon {
  font-color: white;
}