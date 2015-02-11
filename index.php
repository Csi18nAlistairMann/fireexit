<?php
echo "<html>";
echo "<head>";
echo "<script type=\"text/javascript\">";
echo "</script>";
echo "</head>";
unset($trans_sid);
unset($trans_newmark);
unset($trans_lang);
unset($trans_vis);
unset($trans_crid);
unset($trans_trans);
   
$f5reload = 1;
require_once('library.php');

echo "<head>";
echo "<title>";
echo "csi18n proof of concept page";
echo "</title>";
echo "</head>";

echo "<FRAMESET cols='60%, 40%'>";
echo "<FRAME name='mainframe' src='callouts.php$mem&f5reload=1'>";
echo "<FRAMESET rows='35%, 35%, 25%'>";
echo "<FRAME name='translationframe' src='translation-iframe.php$mem&f5reload=1'>";
echo "<FRAME name='serviceframe' src='service-iframe.php$mem&f5reload=1'>";
echo "<FRAME name='httpframe' src='http-iframe.php'>";
echo "</FRAMESET>";
echo "</FRAMESET>";
echo "</FRAMESET>";
echo "</html>";
?>
