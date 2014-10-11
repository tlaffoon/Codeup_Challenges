<?php 

/*

Challenge Prompt:

    Create a function that can detect whether a word is a palindrome or not. 
A palindrome is a word that can be interpreted the same way in reverse order.

    Create the function so it will return a bool value true if the entered word 
is a palindrome. Function name example could be is_palindrome(). After you 
are complete test several known palindromes, then test regular words in your function.
--------------------
Example Palindromes:

	Amore, Roma
	A man, a plan, a canal: Panama
	No 'x' in 'Nixon

*/

function detectPalindrome($string) {

	// Removes all spaces in between words.
	$string = str_replace(' ', '', $string); 
	
	// Removes special characters.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
	
	// Lowercases all the letters.
	$string = strtolower($string); 

	// Checks for palindrome status.
	$result = ($string == strrev($string)) ? true : false ; 

	return $result;
}

// Prompt User
echo "Please enter the string to check: ";
$input = trim(fgets(STDIN));

// Output Result
if (detectPalindrome($input)) {
	fwrite(STDOUT, "\"" . ucfirst($input) . "\"" . " is a palindrome!" . PHP_EOL);
}

else {
	fwrite(STDOUT, "Bummer bro, looks like \"$input\" is not a palindrome." . PHP_EOL);
}


?>