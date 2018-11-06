<?php

include_once 'vendor/autoload.php';

use App\Movie;
use App\Rental;
use App\Customer;


$customer = new Customer('Elizabeth');

// Film "Saya Suka Kamu Punya" mempunyai kode harga REGULAR yang dipinjam selama 2 hari
$movie = new Movie('Saya Suka Kamu Punya', 0);
$rental = new Rental($movie, 2);
$customer->addRental($rental);

// Film "Warkop Reborn" mempunyai kode harga NEW_RELEASE yang dipinjam selama 5 hari
$movie = new Movie('Warkop Reborn', 1);
$rental = new Rental($movie, 5);
$customer->addRental($rental);

// Film "Dora the Explorer" mempunyai kode harga CHILDREN yang dipinjam selama 3 hari
$movie = new Movie('Dora the Explorer', 2);
$rental = new Rental($movie, 3);
$customer->addRental($rental);


echo $customer->statement() . PHP_EOL;
