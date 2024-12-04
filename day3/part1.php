<?php
    $line = file_get_contents('input.txt');
    $output = [];
    $accum = 0;
    preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $line, $output);
    for ($i = 0; $i < count($output[0]); $i++)
    {
        $accum += ($output[1][$i] * $output[2][$i]);
    }
    echo $accum;
