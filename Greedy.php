<?php

declare(strict_types=1);

class Greedy implements Strategy
{
    public function run(array $cities): array
    {
        $result = [];
        /** @var City $now */
        $now = array_shift($cities);
        $result[] = [
            'city' => $now,
            'distance' => 0,
        ];

        do {
            ['index' => $latestIndex, 'distance' => $latestDistance] = $this->getLatestCityIndex($now, $cities);
            $result[] = [
                'city' => $cities[$latestIndex],
                'distance' => $latestDistance,
            ];
            $now = $cities[$latestIndex];
            unset($cities[$latestIndex]);
        } while (count($cities) !== 0);

        // 最後に王都へ戻る
        $start = $result[0]['city'];
        $distance = $now->distance($start);
        $result[] = [
            'city' => $start,
            'distance' => $distance,
        ];

        return $result;
    }

    private function getLatestCityIndex(City $now, array $cities): array
    {
        $minValue = 9999;
        $minxIndex = -1;

        foreach ($cities as $index => $city) {
            $distance = $now->distance($city);
            if ($distance < $minValue) {
                $minValue = $distance;
                $minxIndex = $index;
            }
        }

        if ($minxIndex === -1) {
            throw new LogicException();
        }

        return [
            'index' => $minxIndex,
            'distance' => $minValue,
        ];
    }
}
