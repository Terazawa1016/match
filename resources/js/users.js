//()$document).on(イベント名、対象となる要素、コールバック関数)

//コールバック関数とは関数の中で実行する関数のこと
//ここのchangeイベントはフォーム要素が変更されたときに起こるイベント
$(document).on("change", "#file_photo", function(e) {

  //ユーザがファイルを読み込んだファイルを保持しておく為に必要になるので変数化
  var reader;

  //e.target.files.lengthでファイルの有無を判定
  if (e.target.files.length) {

    //ファイルを操作したいのでFileReaderオブジェクトを作成
    //reader変数にFileReaderオブジェクトのインスタンスを代入する
    reader = new FileReader;

    //ファイルの読み込みが上手くいけばreader.onloadでイベント発生する
    reader.onload = function(e) {

      var userThumbnail;
      //プレビューを表示するための要素を取得
      userThumbnail = document.getElementById('thumbnail');

      //userImgPreview要素に.is-activeクラスがあるとCSSのdisplay:block;が適用
      //画像が表示されるようになる
      $("#userImgPreview").addClass("is-active");
      //ここではimgタグのsrc属性にe.target.resultで取得したファイル名を設定
      userThumbnail.setAttribute('src', e.target.result);
    };    
    return reader.readAsDataURL(e.target.files[0]);
  }
});
