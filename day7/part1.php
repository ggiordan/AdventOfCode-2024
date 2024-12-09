<?php
$lines = explode("\n", file_get_contents('input.txt'));
unset ($lines[count($lines)-1]);

$operators = [];
$total = 0;
foreach($lines as $line){
    $parts = explode(':',trim($line));
    $answer = $parts[0];
    $values = explode(' ', trim($parts[1]));
    $operatorCount = count($values) - 1 ;

    if (array_key_exists($operatorCount,$operators)) {
        $myOperators = $operators[$operatorCount];
    } else {
        $myOperators = generateCombinations($operatorCount);
        $operators[$operatorCount] = $myOperators; 
    }

    foreach ($myOperators as $operator) {
        $accumulator = $values[0];
        for ($i = 0; $i < $operatorCount; $i++ ) {
            switch ($operator[$i]) {
                case '+':
//                    echo "add: $accumulator to {$values[$i+1]}\n";
                    $accumulator += $values[$i+1];
                    break;
                case '*':
//                    echo "multiply: $accumulator to {$values[$i+1]}\n";
                    $accumulator  *= $values[$i+1];
                    break;
            }
        }
        if ($answer == $accumulator) {
            $total += $answer;
//            print_r($values);
//            print_r($answer);
            break;
        }
    }
    
}
echo $total;

function generateCombinations($length) {
    // Base case: if length is 0, return an empty array
    if ($length <= 0) {
        return [];
    }

    // Initialize an array to store combinations
    $combinations = [];
    $characters = ['+', '*'];

    helper("", $length, $characters, $combinations);

    return $combinations;
}
// Recursive function to generate combinations
function helper($current, $length, $characters, &$combinations) {
    if (strlen($current) == $length) {
        $combinations[] = $current;
        return;
    }

    foreach ($characters as $char) {
        helper($current . $char, $length, $characters, $combinations);
    }
}
