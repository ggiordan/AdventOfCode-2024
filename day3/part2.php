<?php
    $line = file_get_contents('input.txt');
    $output = [];
    $accum = 0;
    $status = true;
    preg_match_all('/mul\(\d{1,3},\d{1,3}\)|do\(\)|don\'t\(\)/', $line, $output);
    foreach($output[0] as $element)
    {
        switch($element) {
        case 'do()':
            $status = true;
            break;
        case "don't()":
            $status = false;
            break;
        default:
            if ($status) {
                $values = [];
                preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/',$element, $values);
                $accum += ($values[1][0] * $values[2][0]);
            }
            break;
        }
    }
    echo $accum;
