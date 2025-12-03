<?php
function file_get_contents_curl($url) {
	$headers = array(
	    "HTTP/1.0",
	    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
//	    "Accept-Encoding:gzip ,deflate",
	    "Accept-Language:ja,en-us;q=0.7,en;q=0.3",
	    "Connection:keep-alive",
	    "User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0"
	    );
    // **/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

if($_GET["file"]){
	
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
	// accept only referrer within this site
	header("Access-Control-Allow-Origin: " . "*"); // MUST SET for CORS
	if (preg_match("|^https?://svgmap\.org|", $referer) || preg_match("|^https?://www\.svgmap\.org|", $referer)) { // Set acceptable referer criteria
		if ( $_GET["type"]){
			header("Content-type: " . $_GET["type"]);
		} else {
			if(strpos($_GET["file"],'png')){
				header("Content-type: image/png");
			} else {
				header("Content-Type:image/jpeg;");
			}
		}
//		echo file_get_contents_curl( urldecode($_GET["file"]), true);
		echo file_get_contents_curl( ($_GET["file"]), true);
	} else {
		echo "ERR : referer : " .  $referer;
	}
} else {
	foreach (getallheaders() as $name => $value) {
		echo "$name: $value<br>";
	}
	foreach ($_GET as $key => $value) {
	echo "GET Key:".$key.",  Value:".$value."<br>";
	}
	echo "referrer: ".$_SERVER['HTTP_REFERER'];
}
?>