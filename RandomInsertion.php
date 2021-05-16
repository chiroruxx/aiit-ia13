<?php

declare(strict_types=1);

class RandomInsertion implements Strategy
{
    public function run(array $cities): array
    {
        $routes = [];
        $routes[] = array_shift($cities);

        /** @var City $city */
        foreach ($cities as $city) {
            $minDistance = 9999;
            $minIndex = -1;
            $count = count($routes);
            for ($index = 0; $index < $count - 1; $index++) {
                $city1 = $routes[$index];
                $city2 = $routes[$index + 1];
                $diff = $city->distance($city1) + $city->distance($city2) - $city1->distance($city2);
                if ($minDistance > $diff) {
                    $minDistance = $diff;
                    $minIndex = $index;
                }
            }
            $city1 = $routes[$count - 1];
            $city2 = $routes[0];
            $diff = $city->distance($city1) + $city->distance($city2) - $city1->distance($city2);
            if ($minDistance > $diff) {
                $minIndex = $count - 1;
            }

            if ($minIndex === -1) {
                $routes[] = $city;
            } else {
                $newRoutes = [];
                for ($index = 0; $index < $count; $index++) {
                    $newRoutes[] = $routes[$index];
                    if ($index === $minIndex) {
                        $newRoutes[] = $city;
                    }
                }
                $routes = $newRoutes;
            }
        }

        $routes[] = $routes[0];

        return $this->format($routes);
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
