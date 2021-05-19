<?php

declare(strict_types=1);

class Greedy implements Strategy
{
    public function run(CityList $cities): CityList
    {
        $result = [];
        $first = $cities->shift();
        $now = $first;
        $result[] = $now;

        do {
            $latestCityIndex = $cities->getLatestCityIndex($now);
            $latestCity = $cities->get($latestCityIndex);
            $result[] = $latestCity;
            $now = $latestCity;
            $cities->forget($latestCityIndex);
        } while ($cities->isNotEmpty());

        // 最後に王都へ戻る
        $result[] = $first;

        return new CityList(...$result);
    }
}
