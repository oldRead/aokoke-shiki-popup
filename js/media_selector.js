jQuery(document).ready(function($) {

  let uploader;

  $('button[name="select"]').click(function(e) {
    console.log(e.target.title);
    e.preventDefault();

    let name = e.target.title;  // title属性を読み込み

    uploader = wp.media({
      title: 'Choose Image',
      // ライブラリの表示を画像に限定
      library: {
        type: 'image'
      },
      button: {
        text: "Choose Image"
      },
      multiple: false
    });

    uploader.on('select', function() {
      let images = uploader.state().get('selection');

      // 選択された画像情報を引数fileから取得
      images.each(function(file) {
        // 現在表示されている情報をクリア
        clear(name);
        // 情報を取得し、フルパスとサムネイルを表示
        let photo = file.attributes.sizes.full.url;

        $(`input:text[name="${name}"]`).val(photo);
        $(`.thumbnail[name="${name}"]`).append(`<img src="${photo}">`);
      });
    });
    uploader.open();
  });

  // クリアボタン処理
  $('button[name="clear"]').click(function(e) {
    let name = e.target.title;
    clear(name);
  });

  // 現在表示されている情報をクリアする関数
  function clear(name) {
    $(`input:text[name="${name}"]`).val('');
    $(`.thumbnail[name="${name}"]`).empty();
  }

});
