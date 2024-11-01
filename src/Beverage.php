<?php

namespace RestaurantManagement;

use RestaurantManagement\Traits\PriceTrait;

class Beverage extends AbstractMenuItem {
    use PriceTrait;

    private $isHot;

    public function __construct($name, $price, $category, $isHot) {
        parent::__construct($name, $price, $category);
        $this->isHot = $isHot;
    }

    public function getDetails() {
        return "Menu: $this->name\n" .
            "Kategori: $this->category\n" .
            "Tipe: " . ($this->isHot ? "Panas" : "Dingin") . "\n" .
            "Harga: " . $this->formatPrice($this->price);
    }
}