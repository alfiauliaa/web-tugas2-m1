<?php

namespace RestaurantManagement;

abstract class AbstractMenuItem {
    protected $name;
    protected $price;
    protected $category;

    public function __construct($name, $price, $category) {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
    }

    abstract public function getDetails();

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function __toString() {
        return "$this->name - $this->category";
    }
}