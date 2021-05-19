<?php

declare(strict_types=1);

require_once __DIR__ . '/Strategy.php';
require_once __DIR__ . '/City.php';
require_once __DIR__ . '/CityList.php';
require_once __DIR__ . '/Greedy.php';
require_once __DIR__ . '/TwoOpt.php';
require_once __DIR__ . '/RandomInsertion.php';

$points = getCities();

$cities = [];
foreach ($points as $point) {
    $cities[] = new City(...$point);
}
$cities = new CityList(...$cities);

$strategies = [
    new Greedy(),
    new TwoOpt(),
    new RandomInsertion(),
];

foreach ($strategies as $strategy) {
    $cityList = clone $cities;
    $result = $strategy->run($cityList);

    echo get_class($strategy) . PHP_EOL;
    echo $result . PHP_EOL;
    echo "sum: {$result->getTotalCost()}" . PHP_EOL;
    echo '--------------------------------------------' . PHP_EOL;
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
