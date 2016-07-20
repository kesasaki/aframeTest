<?php

$book = $_GET['book'];
if ($book == null) {
    $book = "gingatetudo";
}
if (true) {
    //require
    require_once('import/phpQuery-onefile.php');

    //ページ取得
    $html = file_get_contents('aozora/' . $book . '.html');

    //DOM取得
    $doc = phpQuery::newDocument($html);

    //要素取得
    $text = $doc["title"]->text();
    $arr = str_split($text, 84);
    $text .= join(" \n ", $arr);
    $text   .= "\n";
    $content = strip_tags($doc[".main_text"]);
    $chunked = explode("\n", $content);
    foreach($chunked as $index => $val) {
        $arr = str_split($val, 84);
        $chunked[$index] = join(" \n ", $arr);
    }
    $content = join("\n\n", $chunked);
//    $arr = str_split($content, 84);
//    $content = join(" \n ", $arr);
//    $chunked = explode('。', $content);
//    $content = join("。\n\n", $chunked);
    $text  .= $content;
}

$font = './resource/ume-tmo3.ttf';

// 画像を生成します
$im = imagecreatetruecolor(820, 1200);
//$im = ImageCreateFromPNG( 'glaybase.png' );

// いくつかの色を生成します
$white = imagecolorallocate($im, 255, 255, 255);
//$grey =  imagecolorallocate($im, 128, 128, 128);
//$black = imagecolorallocate($im, 0, 0, 0);
//imagefilledrectangle($im, 0, 0, 399, 29, $white);
$backgroundColor = imagecolorallocatealpha($im, 20, 20, 20, 20);

imagealphablending($im, true); // ブレンドモードを設定する
imagesavealpha($im, true); // 完全なアルファチャネルを保存する
imagefill($im, 0, 0, $backgroundColor); // 指定座標から指定色で塗る i

// テキストを追加します
imagettftext($im, 20, 0, 30, 40, $white, $font, $text);

// imagepng() を使用して imagejpeg() よりもクリアなテキストにします
imagepng($im, './resource/monolith.png');
imagedestroy($im);
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Composite</title>
    <meta name="description" content="Composite — A-Frame">
    <script src="https://aframe.io/releases/0.2.0/aframe.min.js"></script>
  </head>
  <body>
    <a-scene>
      <a-assets>
        <img id="lake" src="./resource/lake.jpg">
        <img id="pdx" src="./resource/monolith.png">
      </a-assets>
      <a-sky src="#lake"></a-sky>
      <a-image src="#pdx" width="15" height="20" position="0 1.5 1.2" scale="0.3 0.3 0.3"></a-image>
      <a-entity id="wave_sound" sound="autoplay: true; src: ./resource/wave_guiter.ogg; loop: true; on: pause;"></a-entity>
    </a-scene>
    <div>
      <audio controls preload="metadata" id="audio" style="display:none;">
        <source src="./resource/wave_guiter.wav" type="audio/x-wav"/>
      </audio>
    </div>
  </div>
  <script type="text/javascript">
    var entity = document.querySelector('#audio');
    var isPlay = false;

    // タップで開始／停止
    document.addEventListener("touchend", function(e){
        if (!isPlay) {
            entity.play();
            isPlay = true;
        } else {
            entity.pause();
            isPlay = false;
        }
    });

    // 画面を閉じたら止める1
    document.addEventListener('visibilitychange', function(){
        if (document.visibilityState === 'hidden'){
            entity.pause();
        }else if(document.visibilityState === 'visible'){
            entity.play();
        }
    }, false);

    // ループ
    entity.addEventListener('ended', function() {
        this.currentTime = 0;
        this.play();
    });
  </script>
</body>
</html>
