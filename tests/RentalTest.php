<?php

use PHPUnit\Framework\TestCase;
use App\Movie;
use App\Rental;

class RentalTest extends TestCase
{
    public function testMengambilLamaPeminjaman()
    {
        $movie = new Movie('Saya Suka Kamu Punya', 0);
        $rental = new Rental($movie, 5);

        $expected = 5;
        $result = $rental->getDaysRented();

        $this->assertEquals($expected, $result);
    }

    public function testMengambilInfoFilm()
    {
        $movie = new Movie('Saya Suka Kamu Punya', 0);
        $rental = new Rental($movie, 5);


        $expected = 'Saya Suka Kamu Punya';
        $result = $rental->getMovie()->getTitle();

        $this->assertEquals($expected, $result);


        $expected = 0;
        $result = $rental->getMovie()->getPriceCode();

        $this->assertEquals($expected, $result);
    }

    public function testMengambilRentalCharge()
    {
        $movie = new Movie('Saya Suka Kamu Punya', 0);
        $rental = new Rental($movie, 5);

        $expected = 6.5;
        $result = $rental->getCharge();

        $this->assertEquals($expected, $result);
    }
}
