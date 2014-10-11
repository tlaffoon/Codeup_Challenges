<?php	

// Give the User a Main Menu Prompt
function usage() {
	return "(P)lay the Game! | (Q)uit program : ";
}

// Generate Random Word
function generate_random_word() {
	return strtolower(exec('sed `perl -e "print int rand(99999)"`"q;d" /usr/share/dict/words'));
}

// Calculate Length of Word
// strlen($word) . PHP_EOL;

// Get Main Menu Input
function get_input() {
	return strtoupper(trim(fgets(STDIN)));
}

// Allow User Input to Guess at Word; maximum 10 guesses.  Tell them which guess they're on each time.

// Game Loop
function play_game() {

// Display Recurring Prompt with Empty Blanks _ _ _ _ _  or filled in.
// As Letters Are Guessed; Display those Letters instead of Blanks
// When all letters are guessed; display "You Win!" + random trivia

	// create array same length as word that consists of only blanks
	// capture user input, use that input to search original string/word
	// if letter found, then update display array to include that letter
	// check each loop to see if all letters have been guessed; 
	// or allow manual guess.

// var_dump(strlen($word));

	$word = generate_random_word();
	// echo $word . PHP_EOL;

	$word_length = strlen($word);
	$word_array = str_split($word);
	$blank_array = [];

	// create array of blanks corresponding with word generated
	foreach ($word_array as $key => $letter) {
		array_push($blank_array, "_");
	}

	// var_dump($word_array);

	$num_guess = 10;

	do {

		// If first guess; tell them how many letters in word.
		if ($num_guess == 10) {
			echo "Your target word has {$word_length} letters.\n";
		}

		// Each time tell them how many guesses they have left.
		echo "You have {$num_guess} guesses remaining.\n";


		// Echo out array of blanks each time 
		foreach ($blank_array as $key => $value) {
				echo $blank_array[$key];
			}	

		echo "\n";

		// Prompt for user input for next letter guess.
		echo "Your next guess? ";
		$guess = strtolower(get_input());

		// Increment Guess Count Each Time User Guesses
		$num_guess--;

		// Set variable equal to the outcome of array search for user input letter on array created from original string.
		$search = array_search($guess[0], $word_array);
		
		// Search Original Word Array for the User Input Letter; if found then update blanks array with that letter to display.
		if ($search) {
			$blank_array[$search] = $word_array[$search];
			// str_replace($guess, replace, subject)
		}

		// if array search returns true (an integer value of key for the array), then confirm guess
		if (is_numeric($search)) {
			echo "Good guess!  {$word_array[$search]} found in word at index {$search}. ";
		}

	}  while ( $num_guess > 0 && !$word_guessed );

	// If blanks are still found in the blank array after the main loop; assume user lost and give the answer.
	if (is_numeric(array_search('_', $blank_array))) {
		echo "Bummer dude; you lost.  The word was: {$word}\n";
	}

}  // end game function

// ...display the Word Above the Blanks with Each Recurring Prompt

// If they win, give them an option to try again with a new word!

// MAIN LOOP

do {
	echo usage();
	$menu_option = get_input();
	
	// var_dump($menu_option);

	switch ($menu_option) {
		case 'P':
			play_game();
			break;
		
		default:
			if (!empty($menu_option) && $menu_option != 'Q') {
				echo "Please enter a valid menu option.\n";
			}
			break;
	}
} 

while ( $menu_option != 'Q');

?>