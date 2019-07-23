<div class="wrap">
  <h2>AokokeShikiPopupの設定</h2>
  <?php    // プレビューボタン
    submit_button('プレビュー', 'secondary', 'preview', true,
      ['onclick'=>'window.open("'.home_url().'")']);
  ?>
  <form method="post" action="options.php">
    <?php
      submit_button();  // 変更を保存ボタン
      echo $this->html_result;
      settings_fields(self::OPTION_GROUP);
      do_settings_sections(self::OPTION_GROUP);
    ?>
  </form>
</div>

