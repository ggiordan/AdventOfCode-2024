<?

$lines = explode("\n", file_get_contents('input.txt'));
unset ($lines[count($lines)-1]);

for($i = 0; $i < count($lines); $i++) {
    $lines[$i] = str_split($lines[$i]);
}

$count = 0;
for($i = 1; $i < count($lines) - 1; $i++) {
    for($j = 1; $j < count($lines[$i]) -1; $j++) {
        if ($lines[$i][$j] == 'A' &&
            (($lines[$i-1][$j-1] == 'M' && $lines[$i+1][$j+1] == 'S') ||
             ($lines[$i-1][$j-1] == 'S' && $lines[$i+1][$j+1] == 'M') ) &&
            (($lines[$i-1][$j+1] == 'M' && $lines[$i+1][$j-1] == 'S') ||
             ($lines[$i-1][$j+1] == 'S' && $lines[$i+1][$j-1] == 'M') )
        ) {
            echo $lines[$i-1][$j-1].$lines[$i-1][$j].$lines[$i-1][$j+1]."\n";
            echo $lines[$i][$j-1].$lines[$i][$j].$lines[$i][$j+1]."\n";
            echo $lines[$i+1][$j-1].$lines[$i+1][$j].$lines[$i+1][$j+1]."\n";
            echo "\n";
            $count++;
        }
    }
}
echo $count;
