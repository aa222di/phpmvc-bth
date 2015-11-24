<?php
/**
 * Theme related functions. 
 *
 */

function getTimeAgo($timestamp) {
	$date = date("Y-m-d H:i:s", $timestamp);
	$timeAgo = new TimeAgo();
	$time =  $timeAgo->inWords($date);

	return $time;
}

function getLocation($ip) {
	$location = json_decode(file_get_contents('http://freegeoip.net/json/' . $ip));
 	
 	return $location->city . ", " . $location->country_name;
}

/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($email, $size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg?' . ($size ? "s=$size" : null);
}
