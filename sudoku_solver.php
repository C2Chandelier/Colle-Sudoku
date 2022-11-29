<?php


$size = $argv[1] * $argv[1];
$grid=[];

$file = @fopen($argv[2], "r");
if ($file) {
    while (($case = fgets($file, 4096)) !== false) {
        $case = str_replace(".", 0, $case);
        $case = str_split(substr($case, 0, $size));
        array_push($grid, $case);
    }
    fclose($file);
}


solveSudoku($grid,$size,$argv);
/* if(solveSudoku($grid,$size,$argv)){
    print_grid($grid,$size);
} */
/* else{
    echo "Grille impossible à résoudre" . PHP_EOL;
} */

function isSafe($grid, $row, $col, $num, $size, $argv)
{
    for ($d = 0; $d < $size; $d++) {
        if ($grid[$row][$d] == $num) {
            return false;
        }
    }

    for ($r = 0; $r < $size; $r++) {
        if ($grid[$r][$col] == $num) {
            return false;
        }
    }

    $square = $argv[1];
    $boxRowStart = $row - $row % $square;
    $boxColStart = $col - $col % $square;

    for ($r = $boxRowStart; $r < $boxRowStart + $square; $r++) {
        for ($d = $boxColStart; $d < $boxColStart + $square; $d++) {
            if ($grid[$r][$d] == $num) {
                return false;
            }
        }
    }
    return true;
}

function solveSudoku($grid,$size, $argv)
{
    $row = -1;
    $col = -1;
    $isEmpty = true;
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($grid[$i][$j] == 0) {
                $row = $i;
                $col = $j;
                $isEmpty = false;
                break;
            }
        }
        if (!$isEmpty) {
            break;
        }
    }

    if ($isEmpty) {
        return true;
    }

    for ($num = 1; $num <= $size; $num++) {
        if (isSafe($grid, $row, $col, $num, $size, $argv)) {
            $grid[$row][$col] = $num;
            if (solveSudoku($grid, $size, $argv)) {
                print_grid($grid, $size);
                //return true;
            } else {
                $grid[$row][$col] = 0;
            }
        }
    }
    return false;
}

function print_grid($grid, $size)
{
    for ($r = 0; $r < $size; $r++) {
        for ($d = 0; $d < $size; $d++) {
            echo $grid[$r][$d];
        }
        echo "\n";
        if (($r + 1) % 2 == 0)
        {
            echo "";
        }
    }
}


