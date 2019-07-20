<div class="wrap">
  <!-- FontAwesome読み込み -->
  <script src="https://kit.fontawesome.com/f8c88b57ff.js"></script>

  <h2><i class="fas fa-border-all"></i>AokokeShikiPopupの設定</h2>
  <section><p>
    ポップアップの基本設定や各画像に関する設定を行うことができます。<br>
    <ul>
      <li>ポップアップを開始する場合は「表示頻度」を「表示しない」以外に設定してください。</li>
      <li>「プレビュー」ボタンを押した場合には「表示頻度」に関わらず常にポップアップが表示されます。</li>
      <li>現在、ポップアップの表示場所をトップページ以外へ変更することはできません。
    </ul>
  </p></section>
  <form method="post" action="options.php">
    <section class="systems">
      <!-- プレビューボタン（トップページURLにプレビューパラメータを付与） -->
      <input type="button" class="button button-secondary" value="プレビュー"
          onclick="window.open('<?= home_url().'?frompreviewbutton' ?>')"
          title="プレビューの前に設定を保存してください">

      <input type="submit" name="submit" id="submit" class="button button-primary" value="設定を保存">
    </section>
    
    <?php
      echo $this->html_result;      // 各種設定フィールドを出力
      settings_fields(self::OPTION_GROUP);
      do_settings_sections(self::OPTION_GROUP);
    ?>
  </form>
</div>
