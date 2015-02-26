<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--http://mrcoles.com/blog/callout-box-css-border-triangles-cross-browser/ -->
    <style type="text/css">
      .callout {
      position: relative;
      margin: 2px 0;
      padding: 2px 4px;
      /* easy rounded corners for modern browsers */
      -webkit-border-radius: 6px;
      -moz-border-radius: 6px;
      -ms-border-radius: 6px;
      -o-border-radius: 6px;
      border-radius: 8px;
      }

      .callout-dn {
      position: relative;
      margin: 2px 0;
      padding: 2px 4px;
      /* easy rounded corners for modern browsers */
      -webkit-border-radius: 6px;
      -moz-border-radius: 6px;
      -ms-border-radius: 6px;
      -o-border-radius: 6px;
      border-radius: 8px;
      }

      .callout .notch {
      position: absolute;
      top: -10px;
      left: 80px; //changing this moves notch left and right. Too far and disconnects from callout box
      margin: 0;
      border-top: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 10px solid red;
      padding: 0;
      width: 0;
      height: 0;
      /* ie6 height fix */
      font-size: 0;
      line-height: 0;
      /* ie6 transparent fix */
      _border-right-color: pink;
      _border-left-color: pink;
      _filter: chroma(color=pink);
      }

      .border-callout { 
      border: 1px solid #000; padding: 2px 5px; 
      }

      .border-callout .border-notch { 
      border-bottom-color: #0; top: -11px; 
      }

      .callout-dn .notch-dn {
      position: absolute;
      bottom: -10px;
      left: 80px; //changing this moves notch left and right. Too far and disconnects from callout box
      margin: 0;
      border-top: 10px solid red;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 0;
      padding: 0;
      width: 0;
      height: 0;
      /* ie6 height fix */
      font-size: 0;
      line-height: 0;
      /* ie6 transparent fix */
      _border-right-color: pink;
      _border-left-color: pink;
      _filter: chroma(color=pink);
      }

      .border-callout-dn { 
      border: 1px solid #000; padding: 2px 5px; 
      }

      .border-callout-dn .border-notch-dn { 
      border-top-color: #0; bottom: -11px; 
      }

      div.container1
      {
      width:200px;
      height:20px;
      padding:0px;
      text-align:center;
      background:#FFF;
      font-family: "Sans";
      border:1px solid #000000;
      }
    </style>
  </head>

<?php
require_once('library.php');

echo '<body>';
echo "<div>";
echo "<h3>[<a href='/csi18n' target=_parent>&uarr;</a>|<a href='http://csi18n.mpsvr.com/' target=_parent>?</a>] csi18n \"Fire Exit\" <a href='original-fireexit.html'>original</a> | <a href='perspective1.html'>inline</a></h3>";
echo "</div>";
echo "<div>";
echo "<img class='mainimage' src='normandcompany-fireexit.png'>";
echo "<br><font size=-2>Licensed from <a href=\"http://www.normandcompany.com\">Norm And Company</a><br>";
echo "Example code: [ <a href='libcurl.php'>PHP using libcurl</a> | <a href='fopen.php'>PHP using builtins</a> | <a href='ajaxxy.php'>Javascript/AJAX</a> ]";

$visit_sid = 1;
$visit_newmark = "pk-fireexit";
$visit_lang = $al; //es salida de emergencia
$response = get_hash5nunl($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw); 

echo "<div class='callout-dn border-callout-dn' style='position:absolute; top:55px; left:20px; background:#FF0000;'>";
$trans_sid_designer = $visit_sid; // The SID of the designer
$trans_newmark = $visit_newmark;
if ($response['cxr'] === false) {
  $visibility_iv = 'anonymous';
  echo "<div class='container1' name='bub1a'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&trans_sid_designer=$trans_sid_designer&newmark_iv=$visit_newmark&lang_iv=$visit_lang' target='translationframe'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></a></div>";
} else {
  $trans_sid = escapeHtml($response['cxr']['sid']);
  $trans_lang = escapeHtml($response['cxr']['language']);
  $trans_vis = escapeHtml($response['cxr']['visibility']);
  $trans_crid = escapeHtml($response['cxr']['crid']);
  $trans_trans = escapeHtml($response['cxr']['translation']);

  if (isset($f5reload) && $f5reload === "1") {
    echo "<div class='container1' name='bub1b'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&trans_sid_designer=$trans_sid_designer&newmark_iv=$visit_newmark&lang_iv=$trans_lang&trans_sid=$trans_sid&trans_vis=$trans_vis&trans_crid=$trans_crid&trans_trans=$trans_trans' target='translationframe'><strong><font size=+1>" . $trans_trans . "</font></strong></a></div>";
  } else {
    // why is this div different to a reloaded div above? I forget. Remembering to comment 101
    echo "<div class='container1' name='bub1c'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&trans_sid_designer=$trans_sid_designer&trans_sid=$trans_sid&trans_newmark=$trans_newmark&trans_lang=$trans_lang&trans_vis=$trans_vis&trans_crid=$trans_crid&trans_trans=$trans_trans&newmark_iv=$visit_newmark&lang_iv=$trans_lang' target='translationframe'><strong><font size=+1>" . $trans_trans . "</font></strong></a></div>";
  }
}
echo "<b class='border-notch-dn notch-dn' style='border-top-color: black;'></b>";
echo "<b class='notch-dn' style='border-top-color: red'></b>";
echo "</div>";

/*
// Reuse the response to the first bubble. Not reusing the response
// will see bubbles rotate among the uploaded translations
$visit_sid = 1;
$visit_newmark = "pk-fireexit";
$visit_lang = $al; //es salida de emergencia
$response = get_hash5nunl($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw); 
*/
echo "<div class='callout-dn border-callout-dn' style='position:absolute; top:221px; left:21px; background:yellow;'>";
if ($response['cxr'] === false) {
  $visibility_iv = 'anonymous';
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&newmark_iv=$visit_newmark&lang_iv=$visit_lang' target='translationframe'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></a></div>";
  echo "<div class='container1'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></div>";
} else {
  $sid_iv = escapeHtml($response['cxr']['sid']);
  $visibility_iv = escapeHtml($response['cxr']['visibility']);
  $crid_iv = escapeHtml($response['cxr']['crid']);
  $translation_iv = escapeHtml($response['cxr']['translation']);
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$sid_iv&crid_iv=$crid_iv' target='translationframe'><strong>$translation_iv</strong></a></div>";
  echo "<div class='container1'><strong><font size=+1>$translation_iv</font></strong></div>";
}
echo "<b class='border-notch-dn notch-dn' style='border-top-color: black;'></b>";
echo "<b class='notch-dn' style='border-top-color: yellow'></b>";
echo "</div>";

/*
// Reuse the response to the first bubble. Not reusing the response
// will see bubbles rotate among the uploaded translations
$visit_sid = 1;
$visit_newmark = "pk-fireexit";
$visit_lang = $al;
$response = get_hash5nunl($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw); 
*/
echo "<div class='callout border-callout' style='position:absolute; top:565px; left:22px; background:cyan;'>";
if ($response['cxr'] === false) {
  $visibility_iv = 'anonymous';
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&newmark_iv=$visit_newmark&lang_iv=$visit_lang' target='translationframe'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></a></div>";
  echo "<div class='container1'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></div>";
} else {
  $sid_iv = escapeHtml($response['cxr']['sid']);
  $visibility_iv = escapeHtml($response['cxr']['visibility']);
  $crid_iv = escapeHtml($response['cxr']['crid']);
  $translation_iv = escapeHtml($response['cxr']['translation']);
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$sid_iv&crid_iv=$crid_iv' target='translationframe'><strong>$translation_iv</strong></a></div>";
  echo "<div class='container1'><strong><font size=+1>$translation_iv</font></strong></div>";
}
echo "<b class='border-notch notch' style='border-bottom-color: black;'></b>";
echo "<b class='notch' style='border-bottom-color: cyan;'></b>";
echo "</div>";

/*
// Reuse the response to the first bubble. Not reusing the response
// will see bubbles rotate among the uploaded translations
$visit_sid = 1;
$visit_newmark = "pk-fireexit";
$visit_lang = $al;
$response = get_hash5nunl($visit_sid, $visit_newmark, $visit_lang, $apikey, $un, $pw); 
*/
echo "<div class='callout border-callout' style='position:absolute; top:736px; left:23px; background:blue;'>";
if ($response['cxr'] === false) {
  $visibility_iv = 'anonymous';
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$visit_sid&newmark_iv=$visit_newmark&lang_iv=$visit_lang' target='translationframe'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></a></div>";
  echo "<div class='container1'><strong>" . "(" . $response['status_code'] . ") " . $visit_newmark . "</strong></div>";
} else {
  $sid_iv = escapeHtml($response['cxr']['sid']);
  $visibility_iv = escapeHtml($response['cxr']['visibility']);
  $crid_iv = escapeHtml($response['cxr']['crid']);
  $translation_iv = escapeHtml($response['cxr']['translation']);
  //  echo "<div class='container1'><a href='translation-iframe.php$mem&sid_iv=$sid_iv&crid_iv=$crid_iv' target='translationframe'><strong>$translation_iv</strong></a></div>";
  echo "<div class='container1'><strong><font size=+1>$translation_iv</font></strong></div>";
}
echo "<b class='border-notch notch' style='border-bottom-color: black;'></b>";
echo "<b class='notch' style='border-bottom-color: blue;'></b>";
echo "</div>";

?>
    </div>
  </body>

</html>
