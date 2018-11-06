<?php

namespace App;

class Movie
{
    public const REGULAR = 0;
    public const NEW_RELEASE = 1;
    public const CHILDREN = 2;

    private $_title;
    private $_price;

    public function __construct(string $title, int $priceCode)
    {
        $this->_title = $title;
        $this->setPriceCode($priceCode);
    }

    public function getPriceCode(): int
    {
        return $this->_price->getPriceCode();
    }

    public function setPriceCode(int $arg): void
    {
        switch ($arg) {
            case self::REGULAR:
                $this->_price = new RegularPrice();
                break;

            case self::NEW_RELEASE:
                $this->_price = new NewReleasePrice();
                break;

            case self::CHILDREN:
                $this->_price = new ChildrenPrice();
                break;

            default:
                //throw new \Exception("Incorrect Price Code");

        }
    }

    public function getTitle(): string
    {
        return $this->_title;
    }

    public function getCharge(int $daysRented): float
    {
        return $this->_price->getCharge($daysRented);
    }

    public function getFrequentRenterPoints(int $daysRented): int
    {
        return $this->_price->getFrequentRenterPoints($daysRented);
    }
}
