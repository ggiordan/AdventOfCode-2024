<?php

$input = explode("\n", file_get_contents('input.txt'));
$mode = 1;
$rules = [];
$pages = [];
foreach($input as $line) {
	if (strlen($line) == 0) {
		$mode = 2;
		continue;
	}
	switch($mode) {
	case 1:
		$rules[] = explode('|', $line);
		break;
	case 2:
		$pages[] = explode(',', $line);
		break;
	}
}

$validlist = [];
foreach($pages as $page) {
	$good = true;
	print_r($page);
	foreach ($rules as $rule) {
		$a = array_search($rule[0], $page);
		$b = array_search($rule[1], $page);
		if ($a === false || $b === false) {
			continue;
		}
		print_r($rule);
		if ($a >= $b) {
			$good = false;
			continue;
		}
		echo "good\n";
	}
	if ($good == true) {
		$validlist[] = $page;
	}

}

$sum = 0;
foreach ($validlist as $item) {
	$sum += $item[count($item)/2];
}
print_r($sum);


