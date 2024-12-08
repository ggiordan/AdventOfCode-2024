<?php

$lines = explode("\n", file_get_contents('input.txt'));
unset ($lines[count($lines)-1]);

for($i = 0; $i < count($lines); $i++) {
    $lines[$i] = str_split($lines[$i]);
}
$boundaries = ['row' => count($lines), 'col' => count($lines[0])];
printMap($lines);

$count = 0;
do {
	$guard = findGuard($lines);
	moveGuard($guard, $lines, $boundaries);
//	printMap($lines);
print_r($guard); 
$count++;
//if  ($count > 100) exit;
} while ( $guard['row'] >= 0 && $guard['row'] < $boundaries['row']  &&
          $guard['col'] >= 0 && $guard['col'] < $boundaries['col'] );

$count = 0;
foreach($lines as $line) {
	foreach ($line as $cell) {
		if ($cell == 'X') $count++;
	}
}

print_r($boundaries);
print_r($guard);

print_r($count);

exit;

function moveGuard(&$guard, &$map, $boundaries) {
	$col = $guard['col'];
	$row = $guard['row'];
	switch ($guard['guard']) {
	case '^':
		if ($map[$row-1][$col] == '#') {
			$guard['guard'] = '>';
		} else {
			$guard['row']--;
			$map[$row][$col] = 'X';
		}
		break;
	case '>':
		if ($map[$row][$col+1] == '#') {
			$guard['guard'] = 'v';
		} else {
			$guard['col']++;
			$map[$row][$col] = 'X';
		}
		break;
	case 'v':
		if ($map[$row+1][$col] == '#') {
			$guard['guard'] = '<';
		} else {
			$guard['row']++;
			$map[$row][$col] = 'X';
		}
		break;
	case '<':
		if ($map[$row][$col-1] == '#') {
			$guard['guard'] = '^';
		} else {
			$guard['col']--;
			$map[$row][$col] = 'X';
		}
		break;
	}
	$map[$guard['row']][$guard['col']] = $guard['guard'];
	return;
}
function printMap($map) {
	echo "****************\n";
	foreach($map as $row) {
		foreach ($row as $cell) {
			echo $cell;
		}
		echo "\n";
	}
	echo "****************\n";
}

function findGuard($map) {
	for($j = 0; $j < count($map); $j++) {
		for ($i = 0; $i < count($map[$j]); $i++) {
			if ($map[$j][$i] == '^' ||
			    $map[$j][$i] == '>' ||
			    $map[$j][$i] == 'v' ||
			    $map[$j][$i] == '<' )
				return ['col' => $i, 'row' => $j, 'guard' => $map[$j][$i] ];
		}
	}
	return false;
}
