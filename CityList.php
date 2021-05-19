<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

class CityList
{
    /** @var City[] */
    private array $cities;

    public function __construct(City ...$cities)
    {
        $this->cities = array_values($cities);
    }

    public function shift(): City
    {
        return array_shift($this->cities);
    }

    public function get(int $index): City
    {
        return $this->cities[$index];
    }

    public function add(City $city): void
    {
        $this->cities[] = $city;
    }

    public function forget(int $index): void
    {
        unset($this->cities[$index]);
    }

    public function isNotEmpty(): bool
    {
        return count($this->cities) > 0;
    }

    public function count(): int
    {
        return count($this->cities);
    }

    public function first(): ?City
    {
        foreach ($this->cities as $city) {
            return $city;
        }

        return null;
    }

    public function getLatestCityIndex(City $targetCity): int
    {
        $minCost = 9999;
        $minxIndex = -1;

        foreach ($this->cities as $index => $city) {
            $cost = $targetCity->distance($city);
            if ($cost < $minCost) {
                $minCost = $cost;
                $minxIndex = $index;
            }
        }

        if ($minxIndex === -1) {
            throw new LogicException();
        }

        return $minxIndex;
    }

    #[Pure]
    public function getTotalCost(): float
    {
        $total = 0;

        $last = null;
        foreach ($this->cities as $city) {
            if ($last === null) {
                $last = $city;
                continue;
            }

            $total += $city->distance($last);
            $last = $city;
        }

        return $total;
    }

    public function toArray(): array
    {
        return $this->cities;
    }

    public function __toString(): string
    {
        return implode(PHP_EOL, $this->cities);
    }
}
