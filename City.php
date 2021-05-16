<?php

declare(strict_types=1);

class City
{
    public function __construct(private int $x, private int $y)
    {
    }

    public function distance(self $another): float
    {
        $xDistance = $this->x - $another->x;
        $yDistance = $this->y - $another->y;
        return sqrt($xDistance ** 2 + $yDistance ** 2);
    }

    public function __toString(): string
    {
        return "({$this->x}, {$this->y})";
    }

    public function getId(): string
    {
        return "{$this->x}{$this->y}";
    }
}
