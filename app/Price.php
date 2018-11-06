<?php

namespace App;

abstract class Price
{
    abstract function getPriceCode(): int;

    abstract function getCharge(int $daysRented): float;

    public function getFrequentRenterPoints(int $daysRented): int
    {
        return 1;
    }
}
