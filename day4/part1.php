<?

$lines = explode("\n", file_get_contents('input.txt'));
unset ($lines[count($lines)-1]);

// Initialize the result array
$result = $lines;

// Loop through the columns by character index
for ($i = 0; $i < strlen($lines[0]); $i++) {
    $column = "";
    foreach ($lines as $row) {
        $column .= $row[$i];
    }
    $result[] = $column;
}

// Length of rows/columns
$numRows = count($lines);
$numCols = strlen($lines[0]);

// Collect main diagonals
for ($i = 0; $i < $numRows; $i++) {
    for ($j = 0; $j < $numCols; $j++) {
        // Main diagonal: row - col is constant
        $key = $i - $j;
        if (!isset($mainDiagonals[$key])) {
            $mainDiagonals[$key] = "";
        }
        $mainDiagonals[$key] .= $lines[$i][$j];
        
        // Anti-diagonal: row + col is constant
        $key2 = $i + $j;
        if (!isset($antiDiagonals[$key2])) {
            $antiDiagonals[$key2] = "";
        }
        $antiDiagonals[$key2] .= $lines[$i][$j];
    }
}

$result = array_merge($result, $antiDiagonals, $mainDiagonals);

print_r($result);

$count = 0;
foreach ($result as $element) {
    $count += substr_count($element, 'XMAS') + substr_count($element,'SAMX');
    echo "$element $count\n";
}
print_r($count);
