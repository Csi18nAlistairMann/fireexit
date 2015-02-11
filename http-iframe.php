<?php
echo "<html>";
echo "<head>";
echo "<script>";
echo "</script>";
echo "</head>";
echo "<body>";

include('library.php');

echo "<div id='tracker' style='font-family:courier, \"courier new\", monospace; font-size: 60%;'>PK's Fire Exit<hr></div>";
if ($show_source !== 'true') {
  echo "<font size=-2><a id='source' href='$mem&show_source=true' target='_blank'>source</a></font>"; 
} else {
  echo "<hr><code>";
  $fgc = escapeHtml(file_get_contents($_SERVER["SCRIPT_FILENAME"]));
  echo $fgc;
  echo "</code></hr>";
}
echo "</body>";
echo "</html>";
?>
