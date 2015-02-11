<?php

echo "<html>";
echo "<body>";

require_once('library.php');

if ($wpr === 'true') {
  echo "<script>";
  echo "window.parent.frames[0].location.href='callouts.php$mem'; ";
  echo "</script>";
}

echo "<br><br>";
echo "THANK YOU<br>";

if ($sid_iv !== false && $newmark_iv !== false && $lang_iv !== false) {
  $printany = true;
  echo "Newmark: " . urldecode($newmark_iv) . "<br>";
} else {
  $printany = false;
  echo "No newmark in view<br>";
}
   
echo "[ <font size=-2><strike>10000</strike></font> <a href='translation-iframe.php$mem'>Translations home</a> ]<br>";

if ($show_source !== 'true') {
  echo "<font size=-2><a href='$mem&show_source=true' target='_blank'>source</a></font>"; 
} else {
  echo "<hr><code>";
  $fgc = file_get_contents($_SERVER["SCRIPT_FILENAME"]);
  $fgc = preg_replace("|&|", '&amp;', $fgc);
  $fgc = preg_replace("|<|", '&lt;', $fgc);
  $fgc = preg_replace("|>|", '&gt;', $fgc);
  $fgc = preg_replace('|"|', '&quot;', $fgc);
  $fgc = preg_replace("|'|", '&#039;', $fgc);
  $fgc = preg_replace("|\n|", '<br>', $fgc);
  echo $fgc;
  echo "</code></hr>";
}

echo "</body>";
echo "</html>";
?>
