<?php
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

<style>
.aokoke_popup figcaption p {
  font-size: <?= $message_size ?>;
  margin-top: -<?= $message_size ?>;
  line-height: <?= $message_size ?>;
}

.aokoke_popup section p {
  font-size: <?= $title_size ?>;
}

.aokoke_popup .popup_inner {
  border-radius: <?= $radius ?>;
}

</style>
