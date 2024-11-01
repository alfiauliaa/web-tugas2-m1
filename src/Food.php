<?php

namespace RestaurantManagement;

use RestaurantManagement\Traits\PriceTrait;

class Food extends AbstractMenuItem {
    use PriceTrait;

    private $spicyLevel;

    public function __construct($name, $price, $category, $spicyLevel) {
        parent::__construct($name, $price, $category);
        $this->spicyLevel = $spicyLevel;
    }

    public function getDetails() {
        return "Menu: $this->name\n" .
               "Kategori: $this->category\n" .
               "Level Pedas: $this->spicyLevel\n" .
               "Harga: " . $this->formatPrice($this->price);
    }
}