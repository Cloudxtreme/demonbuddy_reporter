<?php
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
		if
			(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
					?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
					$local_array[$i])) {
				return false;
			}
	}
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
function shorten_text($text, $chars = 20) { 
	// Change to the number of characters you want to display 
	if(strlen($text) < $chars)
		return $text;
	$text = $text." "; 
	$text = substr($text,0,$chars); 
	$text = substr($text,0,strrpos($text,' ')); 
	$text = $text."..."; 

	return $text; 

} 

function appendXmlNode($parentNode,$name, $value) {
    $tempNode = new DOMElement($name,$value);
    $parentNode->appendChild($tempNode);
}

function sendXMLviaCurl($xmlRequest,$gatewayURL) {
   // helper function demonstrating how to send the xml with curl


	$ch = curl_init(); // Initialize curl handle
	$CI =& get_instance();
	curl_setopt($ch, CURLOPT_URL, $CI->config->item('gatewayURL')); // Set POST URL

	$headers = array();
	$headers[] = "Content-type: text/xml";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Add http headers to let it know we're sending XML
	$xmlString = $xmlRequest->saveXML();
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); // Fail on errors
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
	curl_setopt($ch, CURLOPT_PORT, 443); // Set the port number
	curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Times out after 15s
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString); // Add XML directly in POST

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);


	// This should be unset in production use. With it on, it forces the ssl cert to be valid
	// before sending info.
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	if (!($data = curl_exec($ch))) {
		print  "curl error =>" .curl_error($ch) ."\n";
		throw New Exception(" CURL ERROR :" . curl_error($ch));

	}
	curl_close($ch);

	return $data;
}

function get_costs_array($cart){	
	$CI =& get_instance();
	$cost = 0;
	//Loop over the order items
	foreach($cart['order_items'] as $product_id => $qty){
		$product = $CI->product_model->get_product_by_id($product_id);
		//Get their price
		$price = $product->price;
		//Multiply by the quantity
		$cost += $price * $qty;
	}
	//Add the shipping cost
	$shipping_cost = 0;
	foreach($cart['shipping_quotes'] as $shipping_quote){
		if($shipping_quote['shipping_quote_id'] == $cart['shipping_option']){
			$shipping_cost = $shipping_quote['cost'];
			break;
		}
	}
	return array('cost'=>$cost, 'shipping_cost'=>$shipping_cost, 'total'=>$cost+$shipping_cost);
}

function vardump($arr, $die = false){
	echo "<pre>";
	var_dump($arr);
	echo "</pre>";
	if($die){
		die();
	}
}

function toASCII( $str )
{
	return strtr(utf8_decode($str), 
		utf8_decode('ŠŒšœŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖØÙÚÛÜİßàáâãäåæçèéêëìíîïğñòóôõöøùúûüıÿ'),
		'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
}

function detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function stripText($text){
	$text = strtolower(trim($text));
	// replace all white space sections with a dash
	$text = str_replace(' ', '-', $text);
	$text = str_replace("'", '', $text);
	// strip all non alphanum or -
	$clean = preg_replace("[^A-Za-z0-9\-]", "", $text);

	return $clean;
}
