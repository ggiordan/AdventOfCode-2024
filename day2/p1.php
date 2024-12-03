<?php

$inputString = file_get_contents('input.txt');

$input = explode("\n", $inputString);
$safeCount = 0;
foreach($input as $line) {
	if (strlen($line) == 0) break;
	$safe = true;
	$items = explode(' ', trim($line));
	if (count($items) == 0) break;

	if ($items[0] < $items[1]) {
		for($i = 0; $i < count($items)-1; $i++) {
			if  ($items[$i] >= $items[$i+1]) {
				$safe = false;
				break;
			}
			if (abs($items[$i] - $items[$i+1]) > 3) {
				$safe = false;
				break;
			}
		}

	} else {
		for($i = 0; $i < count($items)-1; $i++) {
			if  ($items[$i] <= $items[$i+1]) {
				$safe = false;
				break;
			}
			if (abs($items[$i] - $items[$i+1]) > 3) {
				$safe = false;
				break;
			}
	
		}
	}
	if ($safe == true) $safeCount++;
	echo strlen($line)."line: '$line' {$safe}\n";
}
echo $safeCount;
