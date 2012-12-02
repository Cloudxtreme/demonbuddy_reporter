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
