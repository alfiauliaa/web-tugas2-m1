<?php

require_once __DIR__ . '/src/Traits/PriceTrait.php';
require_once __DIR__ . '/src/AbstractMenuItem.php';
require_once __DIR__ . '/src/Food.php';
require_once __DIR__ . '/src/Beverage.php';
require_once __DIR__ . '/src/Order.php';
require_once __DIR__ . '/src/Restaurant.php';

use RestaurantManagement\Restaurant;
use RestaurantManagement\Food;
use RestaurantManagement\Beverage;

// Membuat instance restaurant
$restaurant = new Restaurant("Restaurant");

// Menambahkan menu makanan
$restaurant->addMenuItem(new Food("Nasi Goreng", 25000, "Makanan Utama", "Medium"));
$restaurant->addMenuItem(new Food("Mie Goreng", 23000, "Makanan Utama", "Pedas"));
$restaurant->addMenuItem(new Beverage("Es Teh", 5000, "Minuman", false));
$restaurant->addMenuItem(new Beverage("Kopi", 8000, "Minuman", true));

// Menampilkan menu
$restaurant->displayMenu();

// Membuat pesanan
$order = $restaurant->createOrder();
$order->addItem(new Food("Nasi Goreng", 25000, "Makanan Utama", "Medium"), 1);
$order->addItem(new Food("Kentang Gorwng", 15000, "Camilan", "-"), 1);
$order->addItem(new Beverage("Es Teh", 5000, "Minuman", false), 2);


// Mencetak struk pembayaran
$order->printBill();