<?php

$inputString = file_get_contents('input.txt');

$input = explode("\n", $inputString);
$safeCount = 0;
foreach($input as $line) {
	if (strlen($line) == 0) break;

	$items = explode(' ', trim($line));

	$badCount = checkLine($items);
	if ($badCount < 2)
		$safeCount++;
	else {
		$badCount = checkLine(array_reverse($items));
		if ($badCount < 2)
			$safeCount++;
	}
	echo "$line\t$badCount $safeCount\n";
}
echo $safeCount;
exit;

function checkLine($items) {
	$upcount = 0;
	$downcount = 0;
	$samecount = 0;
	$badcount = 0;
	$goodcount = 0;

	$currentTrend = 0;
	$currentItem = $items[0];
	$items = array_slice($items,1);

	foreach($items as $item) {
		$trend = $item - $currentItem;
		if ($currentTrend < 0 && $trend > 0) {
			$badcount++;
			continue;
		}
		if ($currentTrend > 0 && $trend < 0) {
			$badcount++;
			continue;
		}
		if ($trend == 0 || abs($trend) > 3) {
			$badcount++;
			continue;
		}
		$currentTrend = $trend;
		$currentItem = $item;
		$goodcount;
	}
	return $badcount;
}
