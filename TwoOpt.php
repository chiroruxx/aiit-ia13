<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

class TwoOpt implements Strategy
{
    public function run(CityList $cities): CityList
    {
        $cities->add($cities->first());
        return $this->runProcess($cities);
    }

    private function runProcess(CityList $cities): CityList
    {
        $beforeCost = $cities->getTotalCost();

        $exChangeList = $this->makeExchangeList($cities);

        $cities = $cities->toArray();
        foreach ($exChangeList as [$first, $second]) {
            $subsets = [];
            foreach ($cities as $key => $city) {
                if ($key <= $first) {
                    $subsets[0][] = $city;
                } elseif ($key <= $second) {
                    $subsets[1][] = $city;
                } else {
                    $subsets[2][] = $city;
                }
            }
            krsort($subsets[1]);
            $result = array_merge($subsets[0], $subsets[1], $subsets[2]);
            $result = new CityList(...$result);
            $exChangeCost = $result->getTotalCost();
            if ((int)$exChangeCost < (int)$beforeCost) {
                return $this->runProcess($result);
            }
        }

        return new CityList(...$cities);
    }

    #[Pure]
    private function makeExchangeList(CityList $cities): array
    {
        $cityCount = $cities->count();

        $list = [];
        for ($first = 0; $first < $cityCount; $first++) {
            for ($second = $first + 2; $second < $cityCount - 1; $second++) {
                $list[] = [$first, $second];
            }
        }

        return $list;
    }
}
