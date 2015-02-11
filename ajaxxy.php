<?php
echo "<html><body>";
echo "Example using: ajax";
echo " | <a href='fopen.php'>fopen()</a>";
echo " | <a href='libcurl.php'>libcurl</a><br>";
echo "<hr>";

echo "<div id='result'>Retrieved result goes here</div>";
?>
<script>
// XSS. Storing:
//   hello</a><img src=bogus onerror=alert(1337)><a href="">
// is an XSS vuln: sanitise text before use. In practice, I only seem to 
// use .innerHtml for use so either .innerHtml = escapeHtml(unsafe) or
// name vars as safe/unsafe and only assign a safe to .innerHtml
//
// bjornd @ http://stackoverflow.com/questions/6234773/can-i-escape-html-special-chars-in-javascript
function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}
//" <-- emacs discolours below unless I terminate the stroke-quote-stroke above
		  
		  var newmark = 'pk-fireexit';
		  var language = 'en-CA';
		  var user = 1;
		  
		  // no provision made for detecting errors
		  var xhReq = new XMLHttpRequest();

		  //    https://rest.mpsvr.com/xlates/1/Hello,-world/en-CA/anonymous/2311
		  xhReq.open("GET", "https://rest.mpsvr.com/xlates/7/xkcd-red-rover-el4/en-CA/anonymous/228", false);
		  xhReq.setRequestHeader('Authorization', 'Basic dGVzdDA1OnRlc3Q=');
		  xhReq.setRequestHeader('X-APIKey', '798e31c43d6b9f03aa504a6f88cb4550');
		  xhReq.setRequestHeader('Accept', 'application/json');
		  xhReq.send(null);
		  var serverResponse = xhReq.responseText;
		  if (xhReq.status === '200') {
		    var display = JSON.parse(serverResponse);
		  } else {
		    var display = xhReq.responseText;
		  }
		  document.getElementById('result').innerHTML = escapeHtml(display);
	  
</script>
<?php

echo "<hr>";

$code = htmlentities(file_get_contents("ajaxxy.php"));
echo "<br>This code:<br><textarea cols=100 rows=50>";
echo $code;
echo "</textarea>";

echo "</body></html>";
?>
