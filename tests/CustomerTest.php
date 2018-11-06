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

    public function testMengambilRentalAmount()
    {
        $customer = new Customer('Elizabeth');

        $movie = new Movie('Saya Suka Kamu Punya', 0);
        $rental = new Rental($movie, 5);

        $expected = 6.5;
        $result = $this->invokeMethod($customer, 'amountFor', [$rental]);

        $this->assertEquals($expected, $result);
    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
