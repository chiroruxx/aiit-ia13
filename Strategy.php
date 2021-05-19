<?php

declare(strict_types=1);

interface Strategy
{
    public function run(CityList $cities): CityList;
}