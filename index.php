<?php

declare(strict_types=1);

require_once __DIR__ . '/Strategy.php';
require_once __DIR__ . '/City.php';
require_once __DIR__ . '/Greedy.php';
require_once __DIR__ . '/TwoOpt.php';
require_once __DIR__ . '/RandomInsertion.php';
require_once __DIR__ . '/BB.php';

$points = getCities();

$cities = [];
foreach ($points as $point) {
    $cities[] = new City(...$point);
}

$strategies = [
    new Greedy(),
    new TwoOpt(),
    new RandomInsertion(),
    new BB(),
];

//$strategy = getStrategy();
foreach ($strategies as $strategy) {
    $result = $strategy->run($cities);
    output($result);
    echo '--------------------------------------------' . PHP_EOL;
}

function output(array $result): void
{
    foreach ($result as $value) {
        echo "{$value['city']}: {$value['distance']}" . PHP_EOL;
    }
    echo "sum: " . array_sum(array_column($result, 'distance')) . PHP_EOL;
}


/**
 * @return int[][]
 */
function getCities(): array
{
    return [
        [87, 143,],
        [207, 49,],
        [31, 103,],
        [133, 177,],
        [13, 88,],
        [193, 166,],
        [170, 133,],
        [219, 82,],
        [84, 132,],
        [182, 31,],
        [48, 136,],
        [122, 78,],
        [154, 32,],
        [80, 75,],
        [117, 89,],
        [65, 132,],
        [229, 159,],
        [232, 73,],
        [212, 198,],
        [166, 194,],
    ];
}
