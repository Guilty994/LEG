<?php

	//compare two string and check if the second string contain all the elements of the first one
	function checkString($arr, $str) {

	  $str = preg_replace( array('/[^ \w]+/', '/\s+/'), ' ', strtolower($str) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  $arr = preg_replace( array('/[^ \w]+/', '/\s+/'), ' ', strtolower($arr) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  
	  $matchedString = array_intersect( explode(' ', $str), explode(' ',$arr));

	  if ( count($matchedString) >= sizeof(explode(' ',$arr))) {
		return true;
	  }
	  return false;
	}
	
	//take a a string remove all special characters and swap it with the user symbol
	function changeNameWithSymbol($name,$simbol) {

	  $name = preg_replace( array('/[^ \w]+/', '/\s+/'), $simbol, strtolower($name) ); // Remove Special Characters and extra spaces -or- convert to LowerCase
	  return $name;

	}


?>