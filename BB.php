<?php

declare(strict_types=1);

class BB implements Strategy
{
    private float $minimumCost = 9999;
    private array $result = [];
    private array $cache = [];

    public function run(array $cities): array
    {
        // 王都出発は確定
        $result = [];
        $result[] = array_shift($cities);
        $this->process($cities, $result);

        return $this->format($this->result);
    }

    private function process(array $cities, array $result)
    {
        if (empty($cities)) {
            // 最後が王都は確定
            $result[] = $result[0];
            if ($this->minimumCost > $this->getTotalCost($result)) {
                $this->minimumCost = $this->getTotalCost($result);
                $this->result = $result;
            }
            return;
        }

        foreach ($cities as $key => $city) {
            $subResult = $result;
            $subResult[] = $city;
            if ($this->minimumCost < $this->getTotalCost($subResult)) {
                continue;
            }

            $subCities = [];
            foreach ($cities as $subKey => $subCity) {
                if ($key === $subKey) {
                    continue;
                }
                $subCities[] = $subCity;
            }

            $this->process($subCities, $subResult);
        }
    }

    /** @var City[] $cities */
    private function getTotalCost(array $cities): float
    {
        $total = 0;

        $count = count($cities);
        for ($now = 0; $now < $count - 1; $now++) {
            $one = $cities[$now];
            $another = $cities[$now + 1];
            $cacheKey = $this->createCacheKey($one, $another);
            if (isset($this->cache[$cacheKey])) {
                $distance = $this->cache[$cacheKey];
            } else {
                $distance = $one->distance($another);
                $this->cache[$cacheKey] = $distance;
            }
            $total += $distance;
        }

        return $total;
    }

    private function output(array $cities): void
    {
        echo implode(', ', array_map(fn(City $city): string => $city->__toString(), $cities)) . ": {$this->getTotalCost($cities)}" . PHP_EOL;
    }

    private function createCacheKey(City $one, City $another): string
    {
        $array = [$one->getId(), $another->getId()];
        sort($array);
        return implode('', $array);
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
