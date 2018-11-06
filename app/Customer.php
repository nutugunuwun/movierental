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

            $thisAmount = $this->amountFor($rental);

            // add frequent renter points
            $frequentRenterPoints++;

            // add bonus for a two days new release rental
            if ($rental->getMovie()->getPriceCode() == Movie::NEW_RELEASE && $rental->getDaysRented() > 1){
                $frequentRenterPoints++;
            }

            // show figures for this rental
            $result .= '- ' . $rental->getMovie()->getTitle() . ': ' . $thisAmount . "\n";

            $totalAmount += $thisAmount;
        }

        // add footer lines
        $result .= "\nAmount owed is " . $totalAmount . "\n" .
                   'You earned ' . $frequentRenterPoints . ' frequent renter points' .
                   "\n------------------------------------------------\n";

        return $result;
    }

    private function amountFor(Rental $rental): float
    {
        $result = 0;

        switch($rental->getMovie()->getPriceCode()){
            case Movie::REGULAR:
                $result += 2;
                if ($rental->getDaysRented() > 2){
                    $result += ($rental->getDaysRented() - 2) * 1.5;
                }
                break;

            case Movie::NEW_RELEASE:
                $result += $rental->getDaysRented() * 3;
                break;

            case Movie::CHILDREN:
                $result += 1.5;
                if ($rental->getDaysRented() > 3){
                    $result += ($rental->getDaysRented() - 3) * 1.5;
                }
                break;
        }

        return $result;
    }
}
