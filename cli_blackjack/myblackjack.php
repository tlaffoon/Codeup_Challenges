<?php 

/* ----------------------------- */
// Define Functions

// This function will build the deck.
function buildDeck() {

    // Create an array for suits
    $suits = ['Clubs', 'Hearts', 'Spades', 'Diamonds'];

    // Create an array for cards
    $cards = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

    // Loop through each suit, and then each card per suit.
    foreach ($suits as $suit) {
        foreach ($cards as $card) {
            $deck[] = "$card of $suit";
        }
    }

    // Shuffle deck three times.
    for ($i=1; $i <= 3 ; $i++) { 
        shuffle($deck);
    }

    return $deck;
}

function promptUser() {
    echo "(H)it or (S)tay? ";
    $choice = strtoupper(trim(fgets(STDIN)));
    return $choice;
}

// This function will accept a hand of cards and return a sorted hand.
function sortHand($hand) {

    foreach ($hand as $key => $card) {
        // Explode card string into array to get first word/num.
        $cardArray = explode(' ', $card);

            // Switch on first word.
            switch ($cardArray[0]) {
                case 'Ace':
                    // Assigns Ace to temp variable.
                    $ace = $hand[$key];
                    // Removes Ace from original array.
                    unset($hand[$key]);
                    // Adds Ace back into array, in last position.
                    $hand[] = $ace;
                    break;

                default:
                    // Do nothing.
                    break;
            }  // end switch
        } // end foreach

        return $hand;
}

function isAce($card) {

    $cardArray = explode(' ', $card);

    switch ($cardArray[0]) {
        case 'Ace':
            return true;
            break;
        
        default:
            return false;
            break;
    }
}

function valueCard($card) {

    // Initialize starting value at zero.
    $valueCard = 0;

    // Explode card string into array to get first word/num.
    $cardArray = explode(' ', $card);

    // Switch on first word.
    switch ($cardArray[0]) {
        case 'Ace':
            // Do nothing.
            break;

        case 'King':
            $valueCard += 10;
            break;
        
        case 'Queen':
            $valueCard += 10;
            break;

        case 'Jack':
            $valueCard += 10;
            break;

        default:
            $valueCard += intval($card);
            break;
    }

    return $valueCard;
}

// This function will accept a hand of cards, and return an integer value.
function valueHand($hand, $firstOnly = false) {

    // Initialize at zero
    $valueHand = 0;

    foreach ($hand as $card) {
        if (isAce($card)) {
            if ($valueHand <= 10) {
                $valueHand += 11;
            }
            else {
                $valueHand += 1;
            }
        }

        else {
            $valueHand += valueCard($card);
        }

        if ($firstOnly === true) {
            return $valueHand;    
        }

    } // end foreach

    return $valueHand;
}

// This function will accept a hand and return a string of cards in sentence form.
// It will also include the value of the hand.
// Default value is to show the whole hand, can use $firstOnly to modify for dealer's hand.
function showHand($hand, $firstOnly = false) {
    
    if ($firstOnly) {
        return "$hand[0]. " . "(" . valueHand($hand, true) . ")";
    }

    else {

        // Set last card.
        $lastCard = array_pop($hand);

        // Construct string.
        $string = implode(", ", $hand) . " and $lastCard.";

        // Return last card for value function.
        $hand[] = $lastCard;

        // Return string and value.
        return $string . " (" . valueHand($hand) . ")";
    }
}

function playerWins($hand, $blackjack = false) {
    // ...
}

function dealerWins($hand, $blackjack = false) {
    // ...
}

/* ----------------------------- */
// Initialize Variables

// Build the deck of cards
$deck = buildDeck();

// Initialize a dealer and player hand
$dealerHand = [];
$playerHand = [];

/* ----------------------------- */
// Begin Main Logic

// Deal the first two cards.
for ($i=1; $i <=2 ; $i++) { 
    $playerHand[] = array_pop($deck);
    $dealerHand[] = array_pop($deck);
}

// Echo the dealer hand, only showing the first card
echo "Dealer showing: {$dealerHand[0]}" . PHP_EOL;

// Echo player hand
echo "You have " . showHand($playerHand) . PHP_EOL;

// Allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay.
while (true) {

    $playerHand = sortHand($playerHand);

    // Clear screen
    echo exec('clear');

    // Check player's score
    if (valueHand($playerHand) > 21) {
        echo "You have " . showHand($playerHand) . PHP_EOL;
        echo "You Busted!" . PHP_EOL;
        exit(0);
    }

    elseif (valueHand($playerHand) === 21 && valueHand($dealerHand) !== 21) {
        echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
        echo "You have " . showHand($playerHand) . PHP_EOL;
        echo "Blackjack! You win!" . PHP_EOL;
        exit(0);
    }

    // Show dealer's top card. 
    echo "Dealer showing " . showHand($dealerHand, true) . PHP_EOL;

    // Output player hand and value
    echo "You have " . showHand($playerHand) . PHP_EOL;

    // Prompt User
    $choice = promptUser();

    switch ($choice) {
        case 'H':

            // Fun output!
            echo "You draw the " . end($deck) . "." . PHP_EOL;
            
            // Add One Card
            $playerHand[] = array_pop($deck);

            sleep(2);
            break;

        case 'S':
            break 2;
        
        default:
            echo "Please enter a valid choice." . PHP_EOL;
            sleep(2);
            break;
    }
}

// Show the dealer's hand (all cards)
while (true) {

    $dealerHand = sortHand($dealerHand);

    // Clear screen
    echo exec('clear');

    // Show dealer's hand.
    echo "Dealer has " . showHand($dealerHand) . PHP_EOL;

    // If dealer has greater than 21; bust.
    if (valueHand($dealerHand) > 21) {
        //echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
        echo "Dealer Busted! You win!" . PHP_EOL;
        exit(0);
    }

    // If dealer has 21; dealer wins.
    elseif (valueHand($dealerHand) === 21) {
        //echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
        echo "You have " . showHand($playerHand) . PHP_EOL;
        echo "BlackJack! Dealer Wins!" . PHP_EOL;
        exit(0);
    }

    elseif (valueHand($dealerHand) < 17) {

        // Fun output!
        echo "Dealer draws the " . end($deck) . "." . PHP_EOL;

        // Add one card to dealer's hand
        $dealerHand[] = array_pop($deck);
    }

    else {
        //echo "Breakin' out." . PHP_EOL;
        break;
    }

    sleep(2);
}



// Perform separate loop to check scores and determine round outcome.  Cleaner.
echo exec('clear');

// If dealer has more points, dealer wins regardless of card count.
if (valueHand($dealerHand) > valueHand($playerHand)) {
    echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
    echo "You have " . showHand($playerHand) . PHP_EOL;
    echo "Dealer Wins!" . PHP_EOL;
    exit(0);
}
// If score is equal, and dealer has equal or greater cards, dealer wins.
elseif (valueHand($dealerHand) === valueHand($playerHand)) {
    if (count($dealerHand) >= count($playerHand)) {
        echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
        echo "You have " . showHand($playerHand) . PHP_EOL;
        echo "Dealer Wins!" . PHP_EOL;
        exit(0);
    }
    // Otherwise player wins.
    else {
        echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
        echo "You have " . showHand($playerHand) . PHP_EOL;
        echo "You Win!" . PHP_EOL;
        exit(0);
    }
}

elseif (valueHand($playerHand) > valueHand($dealerHand)) {
    echo "Dealer has " . showHand($dealerHand) . PHP_EOL;
    echo "You have " . showHand($playerHand) . PHP_EOL;
    echo "You Win!" . PHP_EOL;
    exit(0);
}

// end round.

/* Leftover from prompt; will refactor into comments later. */

// at this point, if the player has more than 21, tell them they busted
// otherwise, if they have 21, tell them they won (regardless of dealer hand)

// if neither of the above are true, then the dealer needs to draw more cards
// dealer draws until their hand has a value of at least 17
// show the dealer hand each time they draw a card

// finally, we can check and see who won
// by this point, if dealer has busted, then player automatically wins
// if player and dealer tie, it is a "push"
// if dealer has more than player, dealer wins, otherwise, player wins

?>