<?php

namespace RestaurantManagement;

class Restaurant {
    private $name;
    private $menu = [];
    private $orders = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function addMenuItem(AbstractMenuItem $item) {
        $this->menu[] = $item;
    }

    public function createOrder() {
        $order = new Order();
        $this->orders[] = $order;
        return $order;
    }

    public function displayMenu() {
        echo "\n=== MENU $this->name ===\n";
        foreach ($this->menu as $item) {
            echo "\n" . $item->getDetails() . "\n";
        }
    }
}