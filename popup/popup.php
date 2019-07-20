<?php
namespace Aokoke;

$options = get_option(PopupShiki::OPTION_GROUP, '');
if ($options === '') return;                         // オプションがない場合は終了

$get_value = 'Aokoke\PopupShiki::get_safe_value';    // オプション値の取得メソッド

$link = $get_value($options, PopupShiki::LINK);
$target = $get_value($options, PopupShiki::NEW_TAB) ? '_blank': '_self';
$link_attr = $link ? 'href="'.$link.'" target="'.$target.'"': '';

$opt_message =  PopupShiki::MESSAGE;
$opt_message_size = PopupShiki::MESSAGE_SIZE;
$opt_photo_num = PopupShiki::PHOTO_NUM;
$message = $get_value($options, $opt_message);  // メッセージを取得

// 配列を用意して格納する
$photo = [];
$title = [];
$title_size = [];
for($i=0; $i<$opt_photo_num; $i++) {
  $photo[$i] = $get_value($options, PopupShiki::PHOTO_IMAGE.$i);
  $title[$i] = $get_value($options, PopupShiki::PHOTO_TITLE.$i);
  $title_size[$i] = $get_value($options, PopupShiki::TITLE_SIZE.$i);
}

$radius = $get_value($options, PopupShiki::POPUP_RADIUS);
$photo_pos = ['top left', 'top right', 'bottom left', 'bottom right'];
$title_pos = [($radius === '0'? 'top': 'bottom').' left',
              ($radius === '0'? 'top': 'bottom').' right',
              'top left',
              'top right'];
$title_margin = [ ($radius === '0'? 'margin-top:': 'margin-bottom:'),
              ($radius === '0'? 'margin-top:': 'margin-bottom:'),
              'margin-top:',
              'margin-top:'];
              
$message_size = $get_value($options, PopupShiki::MESSAGE_SIZE).'rem';

// メッセージスタイルを直前で強制適用
$message_style = 'z-index: 2;position: absolute;width: 80%;top: 20%;bottom: 20%;';

?>
<!-- 動的スタイルの上書き -->
<style>
.aokoke_popup figcaption.message p {
  font-size: <?= $message_size ?>;
  margin-top: -<?= $message_size ?>;
  line-height: <?= $message_size ?>;
}
</style>


<!-- FontAwesome読み込み -->
<script src="https://kit.fontawesome.com/f8c88b57ff.js"></script>

<div class="aokoke_popup" id="aokoke_popup">
<div class="popup_inner" id="close_btn" style="<?= 'border-radius:'.$radius.'%'; ?>">
  <div class="close_btn" id="close_btn"><i class="fas fa-times"></i></div>
  <a <?= $link_attr ?>>
  <figure class="gallery">
    <figcaption class="message" style="<?= $message_style ?>">
      <p style="<?= 'font-size:'.$message_size ?>"><?= $message; ?></p>
    </figcaption>
    <?php for($i=0; $i < $opt_photo_num; $i++): ?>
      <section class="photo <?= $photo_pos[$i] ?>">
        <p class="<?= $title_pos[$i] ?>"
          style="<?= 'font-size:'.$title_size[$i].'rem;'.$title_margin[$i].($title_size[$i]/3).'rem;'?>">
          <?= $title[$i] ?>
        </p>
        <img src="<?= $photo[$i] ?>" alt="<?= $title[$i] ?>">
      </section>
    <?php endfor ?>
  </figure>
  </a>
</div>
<div class="black_background" id="black_background"></div>
</div>
