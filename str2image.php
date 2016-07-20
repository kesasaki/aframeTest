<?php

$text = $_GET['text'];
if ($text == null) {
    $text = "";
} else {
    $text = html_entity_decode($text);
}
$chunked = explode(' ', $text);
$text    = join("\n\n", $chunked);

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
        <audio id="wave" src="./wave_guiter.ogg"></audio>
      </a-assets>
      <a-sky src="#lake"></a-sky>
      <a-image src="#pdx" width="15" height="10" position="0 1.2 1.2" scale="0.3 0.3 0.3"></a-image>
      <a-entity id="wave_sound" sound="autoplay: true; src: ./wave_guiter.ogg; loop: true; on: pause;"></a-entity>
    </a-scene>
<script type="text/javascript">
  var entity = document.querySelector('#wave_sound');
  entity.play();
document.addEventListener("touchend",TouchEventFunc);
        function TouchEventFunc(e){
  var entity = document.querySelector('#wave_sound');
  entity.play();
        }
</script>
  </body>
</html>
