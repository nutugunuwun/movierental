<?php

namespace App;

class Rental
{
    private $_movie;
    private $_daysRented;

    public function __construct(Movie $movie, int $daysRented)
    {
        $this->_movie = $movie;
        $this->_daysRented = $daysRented;
    }

    public function getDaysRented(): int
    {
        return $this->_daysRented;
    }

    public function getMovie(): Movie
    {
        return $this->_movie;
    }
}
