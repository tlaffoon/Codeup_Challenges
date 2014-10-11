<?php 

/* 

Problem:

 Create a function alphabet_soup($str) that accepts a string 
and will return the string in alphabetical order. 

 E.g. "hello world" becomes "ehllo dlorw". 
So make sure your function separates and alphabetizes each word separately.		

*/

// Function Definition
function alphabet_soup($string) {

	// Create array of words from $string
	$words = explode(' ', $string);

	// With each word, create array of letters
	foreach ($words as $word) {
		// Create a new array from each word with str_split()
		$letterArray = str_split($word);
		// Alphabetize that array
		sort($letterArray);

		// For each entry in the letter array, output the letter.
		foreach ($letterArray as $letter) {
			// Concatenate each letter onto $newString
			$newString .= "$letter";
		}

		// After each word, add a space
		$newString .= ' ';
	}

	return $newString;

} // end function

// Main Logic

	// Accept user input to create initial string of words.
	echo "Please enter your ingredients for this here alphabet soup: " . PHP_EOL;
	$input = trim(fgets(STDIN));

	// output
	echo alphabet_soup($input) . PHP_EOL;

?>