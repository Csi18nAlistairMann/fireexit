<?php

// XSS. Storing:
//   hello</a><img src=bogus onerror=alert(1337)><a href=\"\">
// is an XSS vuln: sanitise text before use. In practice, I only seem to 
// use .innerHtml for use so either .innerHtml = escapeHtml(unsafe) or
// name vars as safe/unsafe and only assign a safe to .innerHtml
//
// bjornd @ http://stackoverflow.com/questions/6234773/can-i-escape-html-special-chars-in-javascript
// rewritten for php
function escapeHtml($unsafe) {
  $unsafe = preg_replace("|&|", '&amp;', $unsafe);
  $unsafe = preg_replace("|<|", '&lt;', $unsafe);
  $unsafe = preg_replace("|>|", '&gt;', $unsafe);
  $unsafe = preg_replace('|"|', '&quot;', $unsafe);
  $unsafe = preg_replace("|'|", '&#039;', $unsafe);
  $safer = preg_replace("|\n|", '<br>', $unsafe);
  return $safer;
}

echo "<html><body>";
echo "Example using: <a href='ajaxxy.php'>ajax</a>";
echo " | fopen()";
echo " | <a href='libcurl.php'>libcurl</a><br>";
echo "<hr>";

$newmark = "pk-fireexit";
$language = "en-CA";
$user = 1;

$fp = fsockopen("ssl://rest.mpsvr.com", 443, $errno, $errstr, 10);
if (!$fp) {
   $error = true;
//    echo "$errstr ($errno)<br />\n";
} else {
   $error = false;
   $out = "GET /newmarks/$user/$newmark/$language HTTP/1.1\r\n";
   $out .= "Host: rest.mpsvr.com\r\n";
   $out .= "X-APIKey: 798e31c43d6b9f03aa504a6f88cb4550\r\n";
   $out .= "Authorization: Basic dGVzdDA1OnRlc3Q=\r\n";
   $out .= "Connection: Close\r\n\r\n";
   fwrite($fp, $out);
   $received = '';
   while (!feof($fp)) {
       $received .= fgets($fp, 128);
   }
   fclose($fp);
}
if ($error === true) {
   echo "This went wrong<br>";
} else {
   list($headers, $body) = explode("\r\n\r\n", $received);
   $xlate = unserialize($body);

   echo escapeHtml($xlate['csi18n_xlate_resource']['translation']);
}

echo "<hr>";

$code = htmlentities(file_get_contents("fopen.php"));
echo "<br>This code:<br><textarea cols=100 rows=50>";
echo $code;
echo "</textarea>";

echo "</body></html>";
?>
