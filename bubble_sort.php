<?php

function debug($var)
{
    echo "<pre>";
    print_r($var);
    echo '</pre> <br>';
}

$arr = [5, 3, 9, 4];
//$temp = 0;
function bubble_sort($arr): array
{
    for ($i = 0; $i < sizeof($arr); $i++) {
        for ($j = $i; $j < sizeof($arr); $j++) {
            if ($arr[$i] > $arr[$j]) {
                [$arr[$i], $arr[$j]] = [$arr[$j], $arr[$i]];
//                $temp = $arr[$i];
//                $arr[$i] = $arr[$j];
//                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}

debug(bubble_sort($arr));

