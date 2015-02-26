<?php
echo "<html>";
echo "<body>";

include('library.php');

if ($wpr === 'true') {
  echo "<script>";
  echo "window.parent.frames[0].location.href='callouts.php$mem'; ";
  echo "window.parent.frames[1].location.href='translation-iframe.php$mem'; ";
  echo "</script>";
}

echo "[ <font size=-2><strike>200</strike></font> <a href='service-iframe.php$mem'>Service home</a> ]<br>";
echo " + [ <font size=-2><strike>210</strike></font> Credentials ]<br>";
echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>211</font> <a href='$mem&sho_211=true'>Username</a> ]<br>";
if ($sho_211 === 'true') {
  echo "<hr>"; 
  echo "<form action='' method='get'>";
  echo "<input type=text name=un size=30 value='". $un . "'>";
  echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
  echo "<input type=hidden name=newmark_iv value='" . $newmark_iv. "'>";
  echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
  echo "<input type=hidden name=al value='" . $al . "'>";
  echo "<input type=hidden name=apikey value='" . $apikey . "'>";
  echo "<input type=hidden name=pw value='" . $pw . "'>";
  echo "<input type=hidden name='whole_page_reload' value='true'>";
  echo "<input type=hidden name='quality' value='" . $quality . "'>";
  echo "<input type=submit value=Submit>";
  echo "</form>";
  echo "<font size=-2>Users: test05, test06, test07, test08<br>User test05 owns the newmark.</font>";
  echo "<hr>";
}

echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>212</font> <a href='$mem&sho_212=true'>Password</a> ]<br>";
if ($sho_212 === 'true') {
  echo "<hr>"; 
  echo "<form action='' method='get'>";
  echo "<input type=text name=pw size=30 value='". $pw . "'>";
  echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
  echo "<input type=hidden name=newmark_iv value='" . $newmark_iv. "'>";
  echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
  echo "<input type=hidden name=al value='" . $al . "'>";
  echo "<input type=hidden name=apikey value='" . $apikey . "'>";
  echo "<input type=hidden name=un value='" . $un . "'>";
  echo "<input type=hidden name='whole_page_reload' value='true'>";
  echo "<input type=hidden name='quality' value='" . $quality . "'>";
  echo "<input type=submit value=Submit>";
  echo "</form>";
  echo "<hr>";
}

echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>213</font> <a href='$mem&sho_213=true'>API Key</a> ]<br>";
if ($sho_213 === 'true') {
  echo "<hr>"; 
  echo "<form action='' method='get'>";
  echo "<input type=text name=apikey size=30 value='". $apikey . "'>";
  echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
  echo "<input type=hidden name=newmark_iv value='" . $newmark_iv. "'>";
  echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
  echo "<input type=hidden name=al value='" . $al . "'>";
  echo "<input type=hidden name=un value='" . $un . "'>";
  echo "<input type=hidden name=pw value='" . $pw . "'>";
  echo "<input type=hidden name='whole_page_reload' value='true'>";
  echo "<input type=hidden name='quality' value='" . $quality . "'>";
  echo "<input type=submit value=Submit>";
  echo "</form>";
  echo "<hr>";
}

echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>214</font> <a href='https://service.mpsvr.com' target='_blank'>--> Join</a> ]<br>";
echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>215</font> <a href='http://csi18n.mpsvr.com/index.php/Fireexit' target='_blank'>--> documentation</a> ]<br>";

echo " + [ <font size=-2>220</font> <a href='$mem&sho_220=true'>Accept-Language</a> ]<br>";
if ($sho_220 === 'true') {
  echo "<hr>"; 
  echo "<form action='' method='get'>";
  echo "<input type=text name=al size=30 value='". urldecode($al) . "'>"; 
  echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
  echo "<input type=hidden name=newmark_iv value='" . $newmark_iv. "'>";
  echo "<input type=hidden name=lang_iv value='" . urldecode($lang_iv) . "'>";
  echo "<input type=hidden name=apikey value='" . $apikey . "'>";
  echo "<input type=hidden name=un value='" . $un . "'>";
  echo "<input type=hidden name=pw value='" . $pw . "'>";
  echo "<input type=hidden name='whole_page_reload' value='true'>";
  echo "<input type=hidden name='quality' value='" . $quality . "'>";
  echo "<input type=submit value=Submit>";
  echo "</form>";
  echo "<font size=-1><a target=_new href='http://loc.gov/standards/iso639-2/php/code_list.php'>Example language codes</a> or make up your own!</font>";
  echo "<hr>";
}

echo "&nbsp;&nbsp;&nbsp; + [ <strike><font size=-2>221</font> MRU list</strike> (maybe later) ]<br>";
echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>222</font> <a href='$mem&sho_222=true'>Whole list</a> ]<br>";
if ($sho_222 === 'true') {
  echo "<hr>"; 
  echo "<form action='' method='get'>";
  echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
  echo "<input type=hidden name=newmark_iv value='" . $newmark_iv. "'>";
  echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
  echo "<input type=hidden name=apikey value='" . $apikey . "'>";
  echo "<input type=hidden name=un value='" . $un . "'>";
  echo "<input type=hidden name=pw value='" . $pw . "'>";
  echo "<input type=hidden name='whole_page_reload' value='true'>";
  echo "<input type=hidden name='quality' value='" . $quality . "'>";
  echo "<input type=hidden name=al value='". $al . "'>"; 
  echo "<select name=al_add_list size=4 multiple>";
  echo "<option value=klingon>Klingon</option>";
  echo "<option value=en-GB>British English</option>";
  echo "<option value=jp>Japanese</option>";
  echo "<option value=ara>Arabic</option>";
  echo "<option value=heb>Hebrew</option>";
  echo "<option value=ice>Icelandic</option>";
  echo "</select>";

  echo "<input type=submit value=Add>";
  echo "(Reset thru 220 above)";
  echo "</form>";
  echo "<hr>";
}

if ($show_source !== 'true') {
  echo "<font size=-2><a href='$mem&show_source=true' target='_blank'>source</a></font>"; 
} else {
  echo "<hr><code>";
  $fgc = escapeHtml(file_get_contents($_SERVER["SCRIPT_FILENAME"]));
  echo $fgc;
  echo "</code></hr>";
}

echo "</body>";
echo "</html>";
?>
