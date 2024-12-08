<?php

$linesInitial = explode("\n", file_get_contents('input.txt'));
unset ($linesInitial[count($linesInitial)-1]);

for($i = 0; $i < count($linesInitial); $i++) {
    $linesInitial[$i] = str_split($linesInitial[$i]);
}
$boundaries = ['row' => count($linesInitial), 'col' => count($linesInitial[0])];
$guardInitial = findGuard($linesInitial,'^');

$cycles = 0;

for($col = 0; $col < $boundaries['col']; $col++) {
	for ($row = 0; $row < $boundaries['row']; $row++) {
		//echo "\x1B[2J";
		$guard = $guardInitial;
		$lines = $linesInitial;

		if ($lines[$row][$col] != '.') {
			echo "skip\n";
			continue;
		}
		$lines[$row][$col] = 'O';
		//printMap($lines, $guardInitial);
		$count = 0;
		$route = [];
		do {
			$ret = moveGuard($guard, $lines, $boundaries);
			if ($ret != false) {
				if (in_array($ret,$route)) {
					//readline();
					$ret = false;
					$cycles++;
					echo "\ncycled: $cycles";
				} else {
					$route[] = $ret;
				}
			}
			//printMap($lines, $guard);
			//$guard = findGuard($lines,$guardLast);
		} while ($ret != false);
	}
}
echo "\n\nCycles: $cycles"; exit;
$count = 0;
foreach($lines as $line) {
	foreach ($line as $cell) {
		if ($cell == 'X') $count++;
	}
}

exit;
function moveGuard(&$guard, &$map, $boundaries) {
	$col = $guard['col'];
	$row = $guard['row'];
	$guardLast = $guard['guard'];
	switch ($guard['guard']) {
	case '^':
		if (!isset($map[$row-1])) {
			echo "off the board\n";
			//readline();
			return false;
		}
		if ($map[$row-1][$col] == '#' ||
		    $map[$row-1][$col] == 'O') {
			$guard['guard'] = '>';
		} else {
			$guard['row']--;
			if ($guard['last'] == $guard['guard']) {
				$map[$row][$col] = '|';
			} else {
				$map[$row][$col] = '+';
			}
		}
		break;
	case '>':
		if (!isset($map[$row][$col+1])) {
			echo "off the board\n";
			//readline();
			return false;
		}
		if ($map[$row][$col+1] == '#' ||
		    $map[$row][$col+1] == 'O') {
			$guard['guard'] = 'v';
		} else {
			$guard['col']++;
			if ($guard['last'] == $guard['guard']) {
				$map[$row][$col] = '-';
			} else {
				$map[$row][$col] = '+';
			}
		}
		break;
	case 'v':
		if (!isset($map[$row+1])) {
			echo "off the board\n";
			//readline();
			return false;
		}
		if ($map[$row+1][$col] == '#' ||
		    $map[$row+1][$col] == 'O') {
			$guard['guard'] = '<';
			$map[$row][$col] = '|';
		} else {
			$guard['row']++;
			if ($guard['last'] == $guard['guard']) {
				$map[$row][$col] = '|';
			} else {
				$map[$row][$col] = '+';
			}
		}
		break;
	case '<':
		if (!isset($map[$row][$col-1])) {
			echo "off the board\n";
			//readline();
			return false;
		}
		if ($map[$row][$col-1] == '#' ||
		    $map[$row][$col-1] == 'O') {
			$guard['guard'] = '^';
		} else {
			$guard['col']--;
			if ($guard['last'] == $guard['guard']) {
				$map[$row][$col] = '-';
			} else {
				$map[$row][$col] = '+';
			}
		}
		break;
	}
	$map[$guard['row']][$guard['col']] = $guard['guard'];
	$guard['last'] = $guardLast;
	//echo "{$guard['row']},{$guard['col']},{$guardLast}";
	return "{$guard['row']},{$guard['col']},{$guard['guard']}";
}
function printMap($map,$guard) {
//	echo "\x1B[2J";
	echo "\x1B[H";
//	echo  "\033[2J";
	echo "****************\n";
	//usleep(10000);
	foreach($map as $row) {
		foreach ($row as $cell) {
			if ($guard['row'] == $row && $guard['col'] == $col) {
				echo $guard['guard'];
			} else {
				echo $cell;
			}
		}
		echo "\n";
	}
	echo "****************\n";
}

function findGuard($map,$last) {
	for($j = 0; $j < count($map); $j++) {
		for ($i = 0; $i < count($map[$j]); $i++) {
			if ($map[$j][$i] == '^' ||
			    $map[$j][$i] == '>' ||
			    $map[$j][$i] == 'v' ||
			    $map[$j][$i] == '<' )
				return ['col' => $i, 'row' => $j, 'guard' => $map[$j][$i], 'last' => $last ];
		}
	}
	return false;
}
