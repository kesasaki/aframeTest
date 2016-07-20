<?php

$text = $_GET['text'];
if ($text == null) {
    $text = "";
} else {
    $text = html_entity_decode($text);
    $chunked = explode(' ', $text);
    $text    = join("\n\n", $chunked);
}


$font = './ume-tmo3.ttf';

// 画像を生成します
$im = imagecreatetruecolor(820, 600);
//$im = ImageCreateFromPNG( 'glaybase.png' );

// いくつかの色を生成します
$white = imagecolorallocate($im, 255, 255, 255);
//$grey =  imagecolorallocate($im, 128, 128, 128);
//$black = imagecolorallocate($im, 0, 0, 0);
//imagefilledrectangle($im, 0, 0, 399, 29, $white);
$backgroundColor = imagecolorallocatealpha($im, 76, 76, 76, 70);

imagealphablending($im, true); // ブレンドモードを設定する
imagesavealpha($im, true); // 完全なアルファチャネルを保存する
imagefill($im, 0, 0, $backgroundColor); // 指定座標から指定色で塗る i

// テキストを追加します
imagettftext($im, 20, 0, 30, 40, $white, $font, $text);

// imagepng() を使用して imagejpeg() よりもクリアなテキストにします
imagepng($im, './monolith.png');
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
        <img id="lake" src="lake.jpg">
        <img id="pdx" src="./monolith.png">
      </a-assets>
      <a-sky src="#lake"></a-sky>
      <a-image src="#pdx" width="15" height="10" position="0 1.2 1.2" scale="0.3 0.3 0.3"></a-image>
      <a-entity id="wave_sound" sound="autoplay: true; src: ./wave_guiter.ogg; loop: true; on: pause;"></a-entity>
    </a-scene>
    <div>
      <audio controls preload="metadata" id="audio" style="display:none;">
        <source src="wave_guiter.wav" type="audio/x-wav"/>
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
