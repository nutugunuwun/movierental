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
}
