<?php

namespace App;

class Movie
{
    public const REGULAR = 0;
    public const NEW_RELEASE = 1;
    public const CHILDREN = 2;

    private $_title;
    private $_priceCode;

    public function __construct(string $title, int $priceCode)
    {
        $this->_title = $title;
        $this->_priceCode = $priceCode;
    }

    public function getPriceCode(): int
    {
        return $this->_priceCode;
    }

    public function setPriceCode(int $arg): void
    {
        $this->_priceCode = $arg;
    }

    public function getTitle(): string
    {
        return $this->_title;
    }

    public function getCharge(int $daysRented): float
    {
        $result = 0;

        switch($this->getPriceCode()){
            case self::REGULAR:
                $result += 2;
                if ($daysRented > 2){
                    $result += ($daysRented - 2) * 1.5;
                }
                break;

            case self::NEW_RELEASE:
                $result += $daysRented * 3;
                break;

            case self::CHILDREN:
                $result += 1.5;
                if ($daysRented > 3){
                    $result += ($daysRented - 3) * 1.5;
                }
                break;
        }

        return $result;
    }

    public function getFrequentRenterPoints(int $daysRented): int
    {
        if ($this->getPriceCode() == self::NEW_RELEASE && $daysRented > 1){
            return 2;
        } else {
            return 1;
        }
    }
}
