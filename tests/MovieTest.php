<?php

use PHPUnit\Framework\TestCase;
use App\Movie;

class MovieTest extends TestCase
{
    public function testMengambilJudulFilm()
    {
        $movie = new Movie('Saya Suka Kamu Punya', 0);

        $expected = 'Saya Suka Kamu Punya';
        $result = $movie->getTitle();

        $this->assertEquals($expected, $result);
    }

    public function testMengambilKodeHarga()
    {
        $movie = new Movie('Dora the Explorer', 2);

        $expected = 2;
        $result = $movie->getPriceCode();

        $this->assertEquals($expected, $result);
    }

    public function testMengambilRentalCharge()
    {
        $movie = new Movie('Saya Suka Kamu Punya', 0);

        $expected = 6.5;
        $result = $movie->getCharge(5);

        $this->assertEquals($expected, $result);
    }
}
