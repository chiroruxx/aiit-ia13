<?php

declare(strict_types=1);

interface Strategy
{
    public function run(array $cities): array;
}