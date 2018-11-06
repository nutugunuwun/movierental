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
        $result = "\n------------------------------------------------\n" .
                  'Rental Record for ' . $this->getName() . "\n\n";

        foreach($this->_rentals as $rental){
            // show figures for this rental
            $result .= '- ' . $rental->getMovie()->getTitle() . ': ' . $rental->getCharge() . "\n";
        }

        // add footer lines
        $result .= "\nAmount owed is " . $this->getTotalCharge() . "\n" .
                   'You earned ' . $this->getTotalFrequentRenterPoints() . ' frequent renter points' .
                   "\n------------------------------------------------\n";

        return $result;
    }

    public function htmlStatement(): string
    {
        $result = "<H1>Rentals for <EM>" . $this->getName() . "</EM></H1><P>\n";

        foreach($this->_rentals as $rental){
            // show figures for each rental
            $result .= $rental->getMovie()->getTitle() . ': ' . $rental->getCharge() . "<BR>\n";
        }

        // add footer lines
        $result .= '<P>You owe <EM>' . $this->getTotalCharge() . "</EM></P>\n" .
                   'On this rental you earned <EM>' . $this->getTotalFrequentRenterPoints() . '</EM> frequent renter points</P>';

       return $result;
    }

    private function amountFor(Rental $rental): float
    {
        return $rental->getCharge();
    }

    private function getTotalCharge(): float
    {
        $result = 0;

        foreach($this->_rentals as $rental){
            $result += $rental->getCharge();
        }

        return $result;
    }

    private function getTotalFrequentRenterPoints(): int
    {
        $result = 0;

        foreach($this->_rentals as $rental){
            $result += $rental->getFrequentRenterPoints();
        }

        return $result;
    }
}
