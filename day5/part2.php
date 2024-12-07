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

$fixedlist = [];
foreach($pages as $page) {
	echo "************\n";
	$start = $page;
	$fixcount = applyRules($rules,$page);
	print_r($fixcount);
	if ($fixcount > 0) {
	print_r($page);
		print_r($fixcount);
		while($fixcount > 0) {
			$fixcount = applyRules($rules,$page);
		}
		print_r($fixcount);
		$fixedlist[] = $page;
	print_r($page);
	}

}
$sum = 0;
foreach ($fixedlist as $item) {
	$sum += $item[count($item)/2];
}
print_r($fixedlist);
print_r($sum);

exit;
function applyRules($rules, &$page) {
	$fixcount = 0;
	foreach ($rules as $rule) {
		$a = array_search($rule[0], $page);
		$b = array_search($rule[1], $page);
		if ($a === false || $b === false) {
			continue;
		}
		print_r($rule);
		if ($a >= $b) {
			$tmp = $page[$a];
			$page[$a] = $page[$b];
			$page[$b] = $tmp;
			$fixcount++;
			print_r($page);
		}
	}
	return $fixcount;
}
