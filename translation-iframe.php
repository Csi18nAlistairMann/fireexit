<?php

echo "<html>";
echo "<body>";

require_once('library.php');

if ($wpr === 'true') {
  echo "<script>";
  echo "window.parent.frames[0].location.href='callouts.php$mem'; ";
  echo "</script>";
}

if ($sid_iv !== '' && $newmark_iv !== '' && $lang_iv !== '') {
  $printany = true;
  echo "Newmark: " . urldecode($newmark_iv) . "<br>";
} else {
  $printany = false;
  echo "No newmark in view<br>";
}
   
echo "[ <font size=-2><strike>10000</strike></font> <a href='$mem'>Translations home</a> ]<br>";
if ($printany === true) {
  echo " + [ <font size=-2><strike>11000</strike></font> Alternatives ]<br>";
  echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>11100</font> <a href='$mem&sho_11100=true'>See more</a> ]<br>";
  if ($sho_11100 === 'true') {
    $rv = get_hash1bunla($sid_iv, $newmark_iv, $lang_iv, $apikey, $un, $pw);
    echo "<hr>";
    if ($rv !== false) {
      foreach($rv as $alt) {
	$url2prefer = escapeHtml($alt['url']);
	$tmpcrid = escapeHtml($alt['crid']);
	$tmpvisibility = escapeHtml($alt['visibility']);
	$tmplang = escapeHtml($alt['language']);
	$tmpnewmark = escapeHtml($newmark_iv);
	$tmpsid = escapeHtml($alt['sid']);
	echo "<a href=\"$mem&url2prefer=$url2prefer&do_11100=true&whole_page_reload=true&sid_vi=$visit_sid&trans_sid=$tmpsid&trans_newmark=$tmpnewmark&trans_lang=$tmplang&trans_vis=$tmpvisibility&trans_crid=$tmpcrid&trans_trans=" . escapeHtml($alt['translation']) . "$trans_trans&trans_sid_designer=$trans_sid_designer\">" . escapeHtml($alt['translation']) . '</a> (' . escapeHtml($alt['language']) . ')<br>';
      }
    } else {
      echo "No alternatives yet added<br>";
    }
    echo "<hr>";
  }

  echo "&nbsp;&nbsp;&nbsp; + [ <font size=-2>11200</font> <a href='$mem&sho_11200=true'>Offer another</a> ]<br>";
  if ($sho_11200 === 'true') {
    echo "<hr>"; 
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". urldecode($cl) . "'>Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30'></textarea>Translation<br>";
    echo "<select name=visibility_iv size=4>";
    echo "<option value=anonymous>Anonymous</option>";
    echo "<option value=public>Public</option>";
    echo "<option value=private>Private</option>";
    echo "<option value=personal>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    //    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_11200 value=Submit>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<font size=-2>'Private' visibility will one day be paid accounts only</font>";
    echo "<hr>";
  }
  
  $response = get_hash5nunl($trans_sid_designer, $trans_newmark, $trans_lang, $apikey, $un, $pw); 
  if ($response['cxr'] !== false) {
    $can_mod = true;
    echo " + [ <font size=-2>13000</font> <a href='$mem&sho_13000=true'>Edit</a> ]<br>";
  } else {
    $can_mod = false;
    echo " + [ <font size=-2>13000</font> Edit ]<br>";
  }

  if ($sho_13000 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'> Newmark<br>";
    echo "<input type=text name=cl size=30 value='". urldecode($cl) . "' disabled> Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_13000 value=Submit>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<font size=-2>'Private' visibility will one day be on paid accounts only</font>";
    echo "<hr>";
  }

  if ($can_mod === true) {
    echo " + [ <font size=-2>14000</font> <a href='$mem&sho_14000=true'>Delete</a> ]<br>";
  } else {
    echo " + [ <font size=-2>14000</font> Delete ]<br>";
  }
  if ($sho_14000 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". urldecode($cl) . "' disabled>Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30 disabled value='$translation_iv'>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_14000 value='Confirm deletion'>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<hr>";
  }
 
  if ($can_mod === true) {
    echo " + [ <font size=-2>15000</font> <a href='$mem&sho_15000=true'>Lock</a> ] <font size=-2>Must have ownership rights</font><br>";
  } else {
    echo " + [ <font size=-2>15000</font> Lock ]<br>";
  }
  if ($sho_15000 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". $cl . "' disabled> Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30 disabled value='$translation_iv'>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_15000 value='Confirm lock'>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<hr>";
  }

  if ($can_mod === true) {
    echo " + [ <font size=-2>15010</font> <a href='$mem&sho_15010=true'>Unlock</a> ] <font size=-2>Must have ownership rights</font><br>";
  } else {
    echo " + [ <font size=-2>15010</font> Unlock ]<br>";
  }
  if ($sho_15010 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". $cl . "' disabled> Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30 disabled value='$translation_iv'>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_15010 value='Confirm unlock'>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<hr>";
  }

  if ($can_mod === true) {
    echo " + [ <font size=-2>17000</font> <a href='$mem&sho_17000=true'>Bump</a> ] <font size=-2>Must have ownership rights</font><br>";
  } else {
    echo " + [ <font size=-2>17000</font> Lock ]<br>";
  }
  if ($sho_17000 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". $cl . "' disabled> Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30 disabled value='$translation_iv'>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_17000 value='Confirm bump'>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<hr>";
  }

  if ($can_mod === true) {
    echo " + [ <font size=-2>17010</font> <a href='$mem&sho_17010=true'>Unbump</a> ] <font size=-2>Must have ownership rights</font><br>";
  } else {
    echo " + [ <font size=-2>17010</font> Unbump ]<br>";
  }
  if ($sho_17010 === 'true') {
    echo "<hr>"; 
    $visibility_iv = escapeHtml($response['cxr']['visibility']);
    $translation_iv = escapeHtml($response['cxr']['translation']);
    $selectano = $selectpub = $selectpri = $selectper = '';
    if ($visibility_iv === 'anonymous') $selectano = "selected";
    if ($visibility_iv === 'public') $selectpub = "selected";
    if ($visibility_iv === 'private') $selectpri = "selected";
    if ($visibility_iv === 'personal') $selectper = "selected";
      
    echo "<form action='translation-thankyou-iframe.php' method='get'>";
    echo "<input type=text name=newmark_iv size=30 disabled value='". urldecode($newmark_iv) . "'>Newmark<br>";
    echo "<input type=text name=cl size=30 value='". $cl . "' disabled> Content-Languages<br>";
    echo "<textarea type=text name=translation_iv rows=3 cols=30 disabled value='$translation_iv'>$translation_iv</textarea>Translation<br>";
    echo "<select name=visibility_pass_as_hidden size=4 disabled>";
    echo "<option disabled value=anonymous $selectano>Anonymous</option>";
    echo "<option disabled value=public $selectpub>Public</option>";
    echo "<option disabled value=private $selectpri>Private</option>";
    echo "<option disabled value=personal $selectper>Personal</option>";
    echo "</select>Visibility<br>";

    echo "<input type=hidden name=un value='". $un . "'>";
    echo "<input type=hidden name=sid_iv value='" . $sid_iv . "'>";
    echo "<input type=hidden name=newmark_iv value='" . $newmark_iv . "'>";
    echo "<input type=hidden name=lang_iv value='" . $lang_iv . "'>";
    echo "<input type=hidden name=visibility_iv value='" . $visibility_iv . "'>";
    echo "<input type=hidden name=crid_iv value='" . $crid_iv . "'>";
    echo "<input type=hidden name=al value='" . $al . "'>";
    echo "<input type=hidden name=apikey value='" . $apikey . "'>";
    echo "<input type=hidden name=pw value='" . $pw . "'>";
    echo "<input type=hidden name='whole_page_reload' value='true'>";
    echo "<input type=hidden name='quality' value='" . $quality . "'>";
    echo "<input type=submit name=submit_17010 value='Confirm unbump'>";

    echo "<input type=hidden name=trans_sid_designer value='" . $trans_sid_designer . "'>";
    echo "<input type=hidden name=trans_sid value='" . $trans_sid . "'>";
    echo "<input type=hidden name=trans_newmark value='" . $trans_newmark . "'>";
    echo "<input type=hidden name=trans_lang value='" . $trans_lang . "'>";
    echo "<input type=hidden name=trans_vis value='" . $trans_vis . "'>";
    echo "<input type=hidden name=trans_crid value='" . $trans_crid . "'>";
    echo "<input type=hidden name=trans_trans value='" . $trans_trans . "'>";
    echo "</form>";
    echo "<hr>";
  }

  if ($can_mod === true) {
    echo " + [ <font size=-2>16000</font> <a href='$mem&sho_16000=true'>History</a> ]<br>";
  } else {
    echo " + [ <font size=-2>16000</font> History ]<br>";
  }
  if ($sho_16000 === 'true') {
    /*
      Individual records are not deleted, but superceded by another record which is itself flagged as deleted. Thus, it is possible to effect 'undelete' by a PUT to the URI of a deleted record. Only the owner can do this.
      The demosite doesn't demonstrate undelete.
     */
    echo "<hr>";
    //    $rv = get_hash3($pref_sid, $pref_newmark, $pref_lang, $pref_vis, $pref_crid, $apikey, $un, $pw);

    $rv = get_hash3($trans_sid, $trans_newmark, $trans_lang, $trans_vis, $trans_crid, $apikey, $un, $pw);
    if ($rv === false) {
      echo "No history found";
    } else {
      print_r($rv['csi18n_xlate_resource']['datetime_last_change'] . " " . escapeHtml($rv['csi18n_xlate_resource']['translation']) . "<br>");
      while (isset($rv['csi18n_xlate_previous_url'])) {
	// previous_url will not be presented if there isn;t actually a previous to point to
	$rv = get_hash5_simple($rv['csi18n_xlate_previous_url'], $apikey, $un, $pw);
	if ($rv === false) {
	  echo "No existing records found"; //get_hash3 caught this earlier, so shouldnt get here
	} else {
	  $sho_16000_deleted = false;
	  if (isset($rv['csi18n_xlate_resource']['deleted']) && $rv['csi18n_xlate_resource']['deleted'] === 'true' ) {
	    $sho_16000_deleted = true;
	  }
	  
	  if ($sho_16000_deleted === true) {
	    echo "<strike>";
	  }
	  print_r($rv['csi18n_xlate_resource']['datetime_last_change'] . " " . escapeHtml($rv['csi18n_xlate_resource']['translation']));
	  if ($sho_16000_deleted === true) {
	    echo "</strike> deleted";
	  } 
	}
	echo "<br>";
      }
    }
    echo "<hr>";
  }
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
