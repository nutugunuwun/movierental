<?php

namespace App;

class Customer
{
    private $_name;
    private $_rentals = [];

    public function __construct(string $name)
    {
        $this->_name = $name;
    }

    public function addRental(Rental $arg): void
    {
        array_push($this->_rentals, $arg);
    }

    public function getName(): string
    {
        return $this->_name;
    }

    public function statement(): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;

        $result = "\n------------------------------------------------\n" .
                  'Rental Record for ' . $this->getName() . "\n\n";

        foreach($this->_rentals as $rental){

            // add frequent renter points
            $frequentRenterPoints += $rental->getFrequentRenterPoints();
            
            // show figures for this rental
            $result .= '- ' . $rental->getMovie()->getTitle() . ': ' . $rental->getCharge() . "\n";

            $totalAmount += $rental->getCharge();
        }

        // add footer lines
        $result .= "\nAmount owed is " . $totalAmount . "\n" .
                   'You earned ' . $frequentRenterPoints . ' frequent renter points' .
                   "\n------------------------------------------------\n";

        return $result;
    }

    private function amountFor(Rental $rental): float
    {
        return $rental->getCharge();
    }
}
