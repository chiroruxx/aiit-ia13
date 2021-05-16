<?php

declare(strict_types=1);

class TwoOpt implements Strategy
{
    public function run(array $cities): array
    {
        $cities[] = $cities[0];
        $result = $this->runProcess($cities);
        return $this->format($result);
    }

    private function runProcess(array $cities): array
    {
        $beforeCost = $this->getTotalCost($cities);

        $exChangeList = $this->makeExchangeList($cities);

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
            $exChangeCost = $this->getTotalCost($result);
            if ((int)$exChangeCost < (int)$beforeCost) {
                return $this->runProcess($result);
            }
        }

        return $cities;
    }

    public function makeExchangeList(array $cities): array
    {
        $cityCount = count($cities);

        $list = [];
        for ($first = 0; $first < $cityCount; $first++) {
            for ($second = $first + 2; $second < $cityCount - 1; $second++) {
                $list[] = [$first, $second];
            }
        }

        return $list;
    }

    private function getTotalCost(array $cities): float
    {
        /** @var City[] $cities */
        $total = 0;

        $count = count($cities);
        for ($now = 0; $now < $count - 1; $now++) {
            $total += $cities[$now]->distance($cities[$now + 1]);
        }

        return $total;
    }

    private function format(array $cities): array
    {
        $result = [];
        $result[] = [
            'city' => array_shift($cities),
            'distance' => 0,
        ];
        $before = 0;

        foreach ($cities as $city) {
            $result[] = [
                'city' => $city,
                'distance' => $city->distance($result[$before++]['city']),
            ];
        }

        return $result;
    }
}
