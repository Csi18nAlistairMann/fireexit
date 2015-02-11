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
echo " | <a href='fopen.php'>fopen()</a>";
echo " | libcurl<br>";
echo "<hr>";

$newmark = "pk-fireexit";
$language = "en-CA";
$user = 1;

$ch = curl_init("https://rest.mpsvr.com:443/newmarks/$user/$newmark/$language/anonymous");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: rest.mpsvr.com', 'X-APIKey: 798e31c43d6b9f03aa504a6f88cb4550', 'Authorization: Basic dGVzdDA1OnRlc3Q='));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$body = curl_exec($ch);

if ($body === false) {
  echo "This went wrong<br>" . curl_error($ch);
} else {
   $xlate = unserialize($body);

   echo escapeHtml($xlate['csi18n_xlate_resource']['translation']);
}
curl_close($ch);

echo "<hr>";

$code = htmlentities(file_get_contents("libcurl.php"));
echo "<br>This code:<br><textarea cols=100 rows=50>";
echo $code;
echo "</textarea>";

echo "</body></html>";
?>
