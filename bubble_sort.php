<?php

$arr = $_POST["array"];
$count = count($arr);

function bubbleSort ($arr, $n)
{
    for($i = 0; $i < $n; $i++) {
        for($j = 0; $j < $n - $i - 1; $j++) {
            if($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}

print_r(bubbleSort($arr, $count));
