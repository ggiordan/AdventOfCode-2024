<?php

function getBorderPoints($n) {
    $borderPoints = [];

    // Top row
    for ($col = 0; $col < $n; $col++) {
        $borderPoints[] = [0, $col];
    }
    // Right column
    for ($row = 1; $row < $n; $row++) {
        $borderPoints[] = [$row, $n - 1];
    }
    // Bottom row
    for ($col = $n - 2; $col >= 0; $col--) {
        $borderPoints[] = [$n - 1, $col];
    }
    // Left column
    for ($row = $n - 2; $row > 0; $row--) {
        $borderPoints[] = [$row, 0];
    }

    return $borderPoints;
}

function isPointOnLine($x1, $y1, $x2, $y2, $x, $y) {
    // For vertical line
    if ($x1 == $x2) {
        return $x == $x1;
    }

    // For horizontal line
    if ($y1 == $y2) {
        return $y == $y1;
    }

    // For diagonal line, use the slope formula to verify if the point lies on the line
    $slope = ($y2 - $y1) / ($x2 - $x1);
    return $y == $y1 + $slope * ($x - $x1);
}

function sweepUsingBorder($grid, $origin) {
    $n = count($grid); // Determine grid size from the 2D array
    list($x_c, $y_c) = $origin;
    $borderPoints = getBorderPoints($n);
    $validVectors = []; // Array to store vectors meeting the criteria

    foreach ($borderPoints as $borderPoint) {
        list($x_b, $y_b) = $borderPoint;

        // Calculate the points along the line
        $vector = [];
        for ($x = $x_c; $x <= $x_b; $x++) {
            for ($y = $y_c; $y <= $y_b; $y++) {
                // Check if the current point lies on the exact line
                if (isPointOnLine($x_c, $y_c, $x_b, $y_b, $x, $y)) {
                    $vector[] = [$x, $y];
                }
            }
        }

        // Check if the vector has any points
        if (empty($vector)) {
            continue; // Skip to next border point if the vector is empty
        }

        // Get the character in the first cell of the vector (we'll check for consistency)
        list($firstX, $firstY) = $vector[0];
        $firstChar = $grid[$firstX][$firstY];

        // Check if the vector has at least two matching non-empty cells
        $matchingCellsCount = 0;
        $lineCells = []; // Store only valid cells on the line

        foreach ($vector as $cell) {
            list($x, $y) = $cell;

            // Ensure we are within grid bounds and the character matches the first cell
            if ($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
                $content = $grid[$x][$y];
                if ($content === $firstChar && $firstChar !== '.') {
                    $matchingCellsCount++;
                }
                $lineCells[] = [$x, $y, $content]; // Add cell with its content
            }
        }

        // If the vector has at least two matching cells, we add the full vector to the result
        if ($matchingCellsCount >= 2) {
            $validVectors[] = $lineCells; // Add the entire vector with contents
            break; // Stop searching once we find the first valid vector
        }
    }

    return $validVectors; // Return only vectors meeting the criteria
}


$grid = [
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '0', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '0', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '0', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '0', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', 'A', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', 'A', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', 'A', '.', '.', 'A', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
];
$origin = [8,6];

$grid = [
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', 'a', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', 'a', '.'],
    ['.', '.', '.', '.', '.', 'a', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
    ['.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.', '.'],
];
$origin = [4,8];


/*
// Example usage
$grid = [
    ['.', '.', '.', '.', '.'],
    ['.', '.', 'A', '.', '.'],
    ['.', 'A', 'A', 'b', '.'],
    ['.', '.', 'A', '.', '.'],
    ['.', '.', 'A', '.', '.'],
];
$origin = [1, 2];  // Second row, third cell
*/

$result = sweepUsingBorder($grid, $origin);

echo "Valid vectors with at least 2 of the same non-empty character:\n";
foreach ($result as $index => $vector) {
    echo "Vector " . ($index + 1) . ":\n";
    foreach ($vector as $cell) {
        list($x, $y, $content) = $cell;
        echo "[$x, $y] ($content) ";
    }
    echo "\n";
}
