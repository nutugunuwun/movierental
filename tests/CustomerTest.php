<?php

use PHPUnit\Framework\TestCase;
use App\Movie;
use App\Rental;
use App\Customer;

class CustomerTest extends TestCase
{
    public function testMengambilNamaKustomer()
    {
        $customer = new Customer('Elizabeth');

        $expected = 'Elizabeth';
        $result = $customer->getName();

        $this->assertEquals($expected, $result);
    }
}
