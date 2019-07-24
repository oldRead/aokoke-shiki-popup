<?php
  namespace Aokoke;

  $options = get_option(PopupShiki::OPTION_GROUP, '');
  if ($options === '') return;                         // オプションがない場合は終了

  $get_value = 'Aokoke\PopupShiki::get_safe_value';    // オプション値の取得メソッド

  $link = $get_value($options, PopupShiki::LINK);
  $target = $get_value($options, PopupShiki::NEW_TAB) ? '_blank': '_self';

  $opt_message =  PopupShiki::MESSAGE;
  $opt_message_size = PopupShiki::MESSAGE_SIZE;
  $opt_photo_num = PopupShiki::PHOTO_NUM;

  $message = $get_value($options, $opt_message);  // メッセージを取得

  $opt_photo = PopupShiki::PHOTO_IMAGE;
  $opt_title = PopupShiki::PHOTO_TITLE;
  $opt_title_size = PopupShiki::TITLE_SIZE;

  // 配列を用意して格納する
  $photo = [];
  $title = [];
  $title_size = [];

  for($i=0; $i<$opt_photo_num; $i++) {
    $photo[$i] = $get_value($options, $opt_photo.$i);
    $title[$i] = $get_value($options, $opt_title.$i);
    $title_size[$i] = $get_value($options, $opt_title_size.$i);
  }

  $photo_pos = ['top left', 'top right', 'bottom left', 'bottom right'];
?>

<div class="aokoke_popup" id="aokoke_popup">
  <div class="popup_inner">
    <div class="close_btn" id="close_btn"><i class="fas fa-times"></i></div>
    <a href="<?= $link ?>" target="<?= $target ?>">
    <figure class="gallery">
      <figcaption>
        <p><?= $message; ?></p>
      </figcaption>
      <?php for($i=0; $i < $opt_photo_num; $i++): ?>
        <section class="photo <?= $photo_pos[$i] ?>">
          <p><?= $title[$i] ?></p>
          <img src="<?= $photo[$i] ?>" alt="<?= $title[$i] ?>">
        </section>
      <?php endfor ?>
    </figure>
    </a>
  </div>
  <div class="black_background" id="black_background"></div>
</div>
