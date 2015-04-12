<?php

$visit_sid = $visit_newmark = false; //site designer indicates which newmark with these
$visit_lang = false; //site visitor wants above in this language
$pref_sid = $pref_newmark = $pref_lang = $pref_vis = $pref_crid = false; //we'll indicate a preference with these

$trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = false;
$trans_trans = false;
$trans_sid_designer = false;

$sid_iv = $newmark_iv = false; // which of the designer's newmarks is In View
$lang_iv = false; // single language of the newmark In View
$visibility_iv = $crid_iv = false;

$al_add_list = array();
$quality = $un = $pw = $apikey = false;
$submit_17010 = $submit_17000 = false;
$submit_15010 = $submit_15000 = $submit_14000 = $submit_13000 = $submit_11200 = false;
$sho_17010 = $sho_17000 = false;
$sho_13000 = $sho_11200 = $sho_211 = $sho_212 = $sho_213 = $sho_220 = $sho_222 = false;
$sho_11100 = $sho_14000 = $sho_15000 = $sho_15010 = $sho_16000 = false;
$do_11100 = false;
$translation = '';
$url2prefer = '';
$wpr = false;
$show_source = false;
$al = $cl = false;

function get_hash5nunl($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
    //    echo "$errstr ($errno)<br />\n";
  } else {
    $error = false;
    $out = "GET /newmarks/$visit_sid/" . urlencode($visit_newmark) . "/$visit_lang HTTP/1.1\r\n";
    //    $out .= "Host: prod.mpsvr.com\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Accept: application/vnd.php.serialized;v=1.0\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
  }

  $rv = array();
  if ($error === true) {
    $rv = array('status_code' => -1,
		'cxr' => $visit_newmark);
    //    echo "This went wrong<br>";
  } else {
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $status_code = substr($headers, 9, 3);
    $rv['status_code'] = $status_code;
    if ($rv['status_code'] !== '200') {
      $rv['cxr'] = false;
    } else {
      $xlate = unserialize(trim($body));
      $rv['cxr'] =  $xlate['csi18n_xlate_resource'];
      $rv['xlate_loc'] = $xlate['csi18n_xlate_location'];
    }
  }

  show_in_tracker($out, $headers, $body);
  return $rv;
}

/*
  // superceded in favour of structure that holds status code as well as data
function get_hash4($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
    //    echo "$errstr ($errno)<br />\n";
  } else {
    $error = false;
    $out = "GET /newmarks/$visit_sid/" . urlencode($visit_newmark) . "/$visit_lang HTTP/1.1\r\n";
    //    $out .= "Host: prod.mpsvr.com\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Accept: application/vnd.php.serialized;v=1.0\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
  }

  if ($error === true) {
    $rv = $visit_newmark;
    //    echo "This went wrong<br>";
  } else {
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    if (substr($headers, 0, 12) === 'HTTP/1.1 404') {
      $rv = false;
    } else {
      $xlate = unserialize(trim($body));
      $rv =  $xlate['csi18n_xlate_resource'];
    }
  }

  show_in_tracker($out, $headers, $body);
  return $rv;
}
*/

function show_in_tracker($out, $headers, $body) {
  $out = preg_replace("/\r/", '', $out);
  $out = escapeHtml($out);
  $out = "<span style=\'background-color: #ffcccc; overflow: hidden;\'>$out</span>";
  $headers = preg_replace("/\r/", '', $headers);
  $headers = escapeHtml($headers);
  $headers = "<span style=\'background-color: #ffffcc; overflow: hidden;\'>$headers</span>";

  $body1 = $body;
  $body = preg_replace("/\r/", '', $body);
  $body = escapeHtml($body);
  $body = "<span style=\'background-color: #ccffcc; overflow: hidden;\'>$body</span>";

  $both = "$out$headers<br><br>$body<hr>";

  echo "<script>";
  echo "top.frames['httpframe'].document.getElementById('tracker').innerHTML += '" . $both ."';";
  echo "</script>";
}

function get_hash4simple($url, $apikey, $un, $pw) {
  //https:\/\/rest.mpsvr.com\/xlates\/1,92\/pk-fireexit\/en-CA\/anonymous\/404
  $flag = preg_match('|https://rest.mpsvr.com/xlates/(.*)/(.*)/(.*)/(.*)/(.*)|', $url , $match);
  if (!$flag) {
    // not called directly, so should only get here if response
    // from server unexpected
   return array('status_code' => $url, 'cxr' => false);
  } else {
    $sid = $match[1];
    $newmark = $match[2];
    $lang = $match[3];
    $vis = $match[4];
    $crid = $match[5];
    return get_hash4xunlvc($sid, $newmark, $lang, $vis, $crid, $apikey, $un, $pw);
  }
}

function get_hash4xunlvc($trans_sid, $trans_newmark, $trans_lang, $trans_vis, $trans_crid, $apikey, $un, $pw) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $out = "GET /xlates/$trans_sid/" . urlencode($trans_newmark) . "/$trans_lang/$trans_vis/$trans_crid HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Accept: application/vnd.php.serialized;v=1.0\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
  }
  if ($error === true) {
    $rv = $newmark;
  } else {
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    if (substr($headers, 0, 12) === 'HTTP/1.1 404') {
      $rv = false;
    } else {
      $xlate = @unserialize($body);
      $rv =  $xlate; //['csi18n_xlate_resource'];
    }
  }

  show_in_tracker($out, $headers, $body);
  return $rv; 
}

function get_hash5_simple($uri, $apikey, $un, $pw) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;

    $out = "GET $uri HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Accept: application/vnd.php.serialized;v=1.0\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
    //print_r($out . "<br>" . $received);
  }
  if ($error === true) {
    $rv = $newmark;
  } else {
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    if (substr($headers, 0, 12) === 'HTTP/1.1 404') {
      $rv = false;
    } else {
      $xlate = @unserialize($body);
      $rv =  $xlate; //['csi18n_xlate_resource'];
    }
  }

  show_in_tracker($out, $headers, $body);
  return $rv; 
}

function get_hash1bunla($trans_sid, $trans_newmark, $trans_lang, $apikey, $un, $pw) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $out = "GET /newmarks/$trans_sid/" . urlencode($trans_newmark) . "/$trans_lang/all HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Accept: application/vnd.php.serialized;v=1.0\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
  }
  if ($error === true) {
    $rv = $trans_newmark;
    //    echo "This went wrong<br>";
  } else {
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    if (substr($headers, 0, 12) === 'HTTP/1.1 404') {
      $rv = false;
    } else {
      $xlate = @unserialize($body);
      $rv =  $xlate['csi18n_xlate_resources'];
    }
  }

  show_in_tracker($out, $headers, $body);
  return $rv; 
}

// XSS. Storing:
//   hello</a><img src=bogus onerror=alert(1337)><a href=\"\">
// is an XSS vuln: sanitise text before use. In practice, I only seem to 
// use .innerHtml for use so either .innerHtml = escapeHtml(unsafe) or
// name vars as safe/unsafe and only assign a safe to .innerHtml
//
// bjornd @ http://stackoverflow.com/questions/6234773/can-i-escape-html-special-chars-in-javascript
// rewritten for php
function escapeHtml($unsafe) {
  $unsafe = preg_replace("|&#|", 'FindMyBaseWithAErmHeroCar', $unsafe);
  $unsafe = preg_replace("|&|", '&amp;', $unsafe);
  $unsafe = preg_replace("|FindMyBaseWithAErmHeroCar|", '&#', $unsafe);
  $unsafe = preg_replace("|<|", '&lt;', $unsafe);
  $unsafe = preg_replace("|>|", '&gt;', $unsafe);
  $unsafe = preg_replace('|"|', '&quot;', $unsafe);
  $unsafe = preg_replace("|'|", '&#039;', $unsafe);
  $safer = preg_replace("|\n|", '<br>', $unsafe);
  return $safer;
}

$qs = $_SERVER['QUERY_STRING'];
if ($qs != '') {
  $args = explode('&', $qs);
  foreach ($args as $param) {
    list($key, $value) = explode('=', $param);
    if ($key === "translation_iv") $translation_iv = $value; 
    if ($key === "sid_iv") $sid_iv = $value;
    if ($key === "newmark_iv") $newmark_iv = $value;
    if ($key === "lang_iv") $lang_iv = $value;
    if ($key === "visibility_iv") $visibility_iv = $value; 

    if ($key === "trans_sid_designer") $trans_sid_designer = $value;

    if ($key === "trans_sid") $trans_sid = $value;
    if ($key === "trans_newmark") $trans_newmark = $value;
    if ($key === "trans_lang") $trans_lang = $value;
    if ($key === "trans_vis") $trans_vis =  $value;
    if ($key === "trans_crid") $trans_crid = $value;
    if ($key === "trans_trans") $trans_trans = $value;

    if ($key === "show_source") $show_source = $value;
    if ($key === "al") $al = $value;
    if ($key === "un") $un = $value;
    if ($key === "pw") $pw = $value;
    if ($key === "apikey") $apikey = $value;
    if ($key === "sho_211") $sho_211 = $value;
    if ($key === "sho_212") $sho_212 = $value;
    if ($key === "sho_213") $sho_213 = $value;
    if ($key === "sho_220") $sho_220 = $value;
    if ($key === "sho_222") $sho_222 = $value;
    if ($key === "sho_11200") $sho_11200 = $value;
    if ($key === "sho_13000") $sho_13000 = $value;
    if ($key === "whole_page_reload") $wpr = $value;
    if ($key === "quality") $quality = $value;
    if ($key === "al_add_list") $al_add_list[] = $value;
    if ($key === "cl") $cl = $value; 
    //    if ($key === "cl_add_list") $cl_add_list[] = $value;
    if ($key === "submit_11200") $submit_11200 = $value; 
    if ($key === "submit_13000") $submit_13000 = $value; 
    if ($key === "submit_14000") $submit_14000 = $value; 
    if ($key === "submit_15000") $submit_15000 = $value; 
    if ($key === "submit_15010") $submit_15010 = $value; 
    if ($key === "sho_11100") $sho_11100 = $value;
    if ($key === "sho_14000") $sho_14000 = $value;
    if ($key === "sho_15000") $sho_15000 = $value;
    if ($key === "sho_15010") $sho_15010 = $value;
    if ($key === "sho_16000") $sho_16000 = $value;
    if ($key === "sho_17000") $sho_17000 = $value;
    if ($key === "sho_17010") $sho_17010 = $value;
    if ($key === "submit_17000") $submit_17000 = $value; 
    if ($key === "submit_17010") $submit_17010 = $value; 
    if ($key === "do_11100") $do_11100 = $value;

    if ($key === "url2prefer") $url2prefer = $value;
    if ($key === "f5reload") $f5reload = $value;
  }
  if ($trans_newmark == '') $trans_newmark = $newmark_iv;
  if ($trans_lang == '') $trans_lang = $lang_iv;
}

//if ($al == '') $al = urlencode($_SERVER['HTTP_ACCEPT_LANGUAGE']);
if ($al == '') $al = 'en-CA';
if ($un == '') $un = 'test05';
if ($pw == '') $pw = 'test';
if ($apikey == '') $apikey = '798e31c43d6b9f03aa504a6f88cb4550';
if ($quality == '') $quality = '1.000';
//
// handle adding new Accept-Languages
if ($al_add_list !== array()) {
  $add = '';
  foreach($al_add_list as $add_lang){
    $add .= ", $add_lang;q=$quality";
  }
  $al = $al . $add;
  $quality -= 0.001;
}
//
// Initial Content-Language if necessary (based on Accept-Language)
$can = '';
if ($cl == '') {
  $can_add = '';
  $lang_list = explode(',', $al);
  foreach($lang_list as $cand) {
    $cand_els = explode(';', $cand);
    $can_el = $cand_els[0];
    $can_add .= ",$can_el";
  }
  $cl = substr($can_add, 1);
}
//
// handle submission of new translation
if ($submit_11200 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
    //    echo "$errstr ($errno)<br />\n";
  } else {
    $error = false;
    $x = json_encode(array('csi18n_xlate_resource' => array('newmark' => $newmark_iv,
							  'language' => urldecode($cl),
							  'visibility' => $visibility_iv,
							  'translation' => urldecode($translation_iv))));
    $x .= "\r\n\r\n";

    $out = "POST /newmarks/me/" . $newmark_iv . " HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";

    $out .= $x;
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (404) : echo "404 - No resource found at that URI"; break;
    case (409) : echo "409 - Conflict. Update identical to current"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
    echo "<br><hr>";
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
}

//
// handle submission of existing translation
if ($submit_13000 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $x = json_encode(array('csi18n_xlate_resource' => array('newmark' => $trans_newmark,
							  'langs' => urldecode($trans_lang),
							  'visibility' => $visibility_iv,
							  'translation' => urldecode($translation_iv))));
    $x .= "\r\n\r\n";
    $out = "PUT /xlates/$trans_sid/" . $trans_newmark . "/" . urldecode($trans_lang) . "/$trans_vis/$trans_crid HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $x;
    //    print_r($out);    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (404) : echo "404 - No resource found at that URI"; break;
    case (409) : echo "409 - Conflict. Update identical to current"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
    echo "<br><hr>";
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
}

//
// handle deletion of existing translation
if ($submit_14000 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $out = "DELETE /xlates/$trans_sid/" . $trans_newmark . "/" . urldecode($trans_lang) . "/$trans_vis/$trans_crid HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (404) : echo "404 - No resource found at that URI"; break;
    case (409) : echo "409 - Conflict. Update identical to current"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
    echo "<br><hr>";
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
  $trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = $trans_trans = false;
}

//
// handle preferance of a translation
if ($do_11100 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $x = json_encode(array('csi18n_xlate_resource' => array('location' => base64_encode($url2prefer))));
    $x .= "\r\n\r\n";
    $out = "PUT /newmarks/$sid_iv/" . urlencode($newmark_iv) . "/" . urldecode($lang_iv) . " HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $x;
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);
   
    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (201) : echo "201 - Preference accepted"; break;
    case (409) : echo "409 - Conflict. Update identical to current"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
}

//
// handle lock of existing translation
if ($submit_15000 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $url2prefer = "https://rest.mpsvr.com/xlates/$trans_sid/$trans_newmark/$trans_lang/$trans_vis/$trans_crid";
    $x = json_encode(array('csi18n_xlate_resource' => array('url_base64' => base64_encode($url2prefer))));
    $x .= "\r\n\r\n";
    $out = "PUT /newmarks/$trans_sid_designer/" . $trans_newmark . "/" . urldecode($trans_lang) . "/lock HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $x;
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (201) : echo "201 - Locked successfully"; break;
    case (409) : echo "409 - Already locked"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
  $trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = $trans_trans = false;
}

//
// handle lock of existing translation
if ($submit_15010 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $out = "DELETE /newmarks/$trans_sid_designer/" . $trans_newmark . "/" . urldecode($trans_lang) . "/lock HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (409) : echo "409 - Conflict. May already be unlocked"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
  $trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = $trans_trans = false;
}

//
// handle bump of existing translation
if ($submit_17000 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $x = json_encode(array('csi18n_xlate_resource' => array('visibility' => $trans_vis,
							    'bumped' => 'true')));
    $x .= "\r\n\r\n";
    $out = "PUT /bumps/" . $trans_sid . "," . $trans_crid . " HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $x;
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (201) : echo "201 - Bumped successfully"; break;
    case (409) : echo "409 - Already bumped"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
  $trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = $trans_trans = false;
}

//
// handle unbump of existing translation
if ($submit_17010 !== false) {
  $fp = fsockopen("tls://rest.mpsvr.com", 443, $errno, $errstr, 10);
  if (!$fp) {
    $error = true;
  } else {
    $error = false;
    $x = json_encode(array('csi18n_xlate_resource' => array('visibility' => $trans_vis,
							    'bumped' => 'false')));
    $x .= "\r\n\r\n";
    $out = "PUT /bumps/" . $trans_sid . "," . $trans_crid . " HTTP/1.1\r\n";
    $out .= "Host: rest.mpsvr.com\r\n";
    $out .= "X-APIKey: $apikey\r\n";
    $out .= "Authorization: Basic " . base64_encode("$un:$pw") . "\r\n";
    $out .= "Content-Type: application/json;v=1.0\r\n";
    $out .= "Content-Length: " . mb_strlen($x) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $x;
    
    fwrite($fp, $out);
    $received = '';
    while (!feof($fp)) {
      $received .= fgets($fp, 128);
    }
    fclose($fp);

    list($headers, $body) = explode("\r\n\r\n", $received, 2);
    $rv = substr($headers, 9, 3);
    switch($rv){
    case (201) : echo "201 - Unbumped successfully"; break;
    case (409) : echo "409 - Already bumped"; break;
    default: 
      $headers_arr = explode("\r\n", $headers);
      echo substr($headers_arr[0], 9); break;
    }

    show_in_tracker($out, $headers, $body);
  }
  if ($error === true) {
    echo "This went wrong<br>";
  }
  $newmark_iv = urldecode($newmark_iv);
  $trans_sid = $trans_newmark = $trans_lang = $trans_vis = $trans_crid = $trans_trans = false;
}

if (isset($f5reload) && $f5reload === "1") {
  $mem = "?al=$al&un=$un&pw=$pw&apikey=$apikey&quality=$quality&cl=$cl&sid_iv=$sid_iv&newmark_iv=$newmark_iv&lang_iv=$lang_iv&visibility_iv=$visibility_iv&crid_iv=$crid_iv&trans_sid_designer=$trans_sid_designer";
} else {
  $mem = "?al=$al&un=$un&pw=$pw&apikey=$apikey&quality=$quality&cl=$cl&sid_iv=$sid_iv&newmark_iv=$newmark_iv&lang_iv=$lang_iv&visibility_iv=$visibility_iv&crid_iv=$crid_iv&trans_sid=$trans_sid&trans_newmark=$trans_newmark&trans_lang=$trans_lang&trans_vis=$trans_vis&trans_crid=$trans_crid&trans_trans=$trans_trans&trans_sid_designer=$trans_sid_designer";
}
?>
