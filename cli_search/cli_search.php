<?php
// CLI Interface Exercise
// Get File Input
// Get User Input
// Filter File Data based on User Input

/*  Desired output is a list of either State, Capitol, or Bird 
consisting of those entries which start with a user specified letter. */

$parse_check = 'FALSE';

function get_input() {
	return strtoupper(trim(fgets(STDIN)));
}

function usage() {
	return "(L)ist Raw Data | (S)earch Raw Data | (Q)uit program : ";
}

function output_file_data_unfiltered($filename = './data/filter_input.txt') {
	$handle = fopen($filename, 'r');
	$data = fread($handle, filesize($filename));
	fclose($handle);
	return $data;
}

function search($filename = './data/filter_input.txt') {
	echo "Search by first letter for (S)tate, (C)apitol, or (B)ird : ";
	$search_type = get_input();

	echo "Which letter would you like to search for? ";
	$search_letter = get_input();

		// If file hasn't been parsed already, do so.

		if ($parse_check == FALSE) {

			$handle = fopen($filename, 'r');
			$data = fread($handle, filesize($filename));
			fclose($handle);

			$state_index = [];

			$States = [];
			$Capitols = [];
			$Birds = [];

			foreach (explode("\n", $data) as $key => $value) {
				array_push($state_index, (explode(", ", $value)));
			}

			foreach ($state_index as $key => $value) {
				array_push($States, "$value[0]");
				array_push($Capitols, "$value[1]");
				array_push($Birds, "$value[2]");
			}

			$parse_check = TRUE; 
		}
		
		// Perform Search

		switch ($search_type) {
			case 'S':
				echo "Searching for States starting with: {$search_letter}\n";
				foreach ($States as $state) {
					if ($state[0] == "$search_letter") {
						echo "$state" . PHP_EOL;
						$count++;
					}
				}
				break;

			case 'C':
				echo "Searching for Capitols starting with: {$search_letter}\n";
				foreach ($Capitols as $capitol) {
					if ($capitol[0] == "$search_letter") {
						echo "$capitol" . PHP_EOL;
						$count++;
					}
				}
				break;

			case 'B':
				echo "Searching for Birds starting with: {$search_letter}\n";
				foreach ($Birds as $bird) {
					if ($bird[0] == "$search_letter") {
						echo "$bird" . PHP_EOL;
						$count++;
					}
				}
				break;

			default:
				echo "Please enter a valid sort option." . PHP_EOL;
				break;
		}

		if ($count > 0) {
			return "Search completed with {$count} results." . PHP_EOL;
		}

		else {
			return "Search completed.  No matching results." . PHP_EOL;
		}
}


// MAIN LOOP

do {
	
	echo usage();
	$menu_option = get_input();

	switch ($menu_option) {
		
		case 'L':
			echo "Outputting file data..." . PHP_EOL;
			echo output_file_data_unfiltered() . PHP_EOL;
			break;
		
		case 'S':
			echo search();
			break;

		default:
			if (!empty($menu_option) && $menu_option != 'Q') {
				echo "Please enter a valid menu option.\n";
			}
			break;
	}

} while ($menu_option != 'Q');

?>