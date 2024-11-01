<?php

namespace RestaurantManagement;

use RestaurantManagement\Traits\PriceTrait;

class Order {
    use PriceTrait;

    private $orderItems = [];
    private $orderNumber;
    private $orderTime;

    public function __construct() {
        $this->orderNumber = uniqid('ORD-');
        $this->orderTime = date('Y-m-d H:i:s');
    }

    public function addItem(AbstractMenuItem $item, $quantity = 1) {
        $this->orderItems[] = [
            'item' => $item,
            'quantity' => $quantity
        ];
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->orderItems as $orderItem) {
            $total += $orderItem['item']->getPrice() * $orderItem['quantity'];
        }
        return $total;
    }

    public function printBill() {
        echo "\n=== STRUK PEMBAYARAN ===\n";
        echo "No. Order: $this->orderNumber\n";
        echo "Waktu: $this->orderTime\n";
        echo "----------------------\n";
        
        foreach ($this->orderItems as $orderItem) {
            $item = $orderItem['item'];
            $quantity = $orderItem['quantity'];
            $subtotal = $item->getPrice() * $quantity;
            
            echo $item->getName() . " x " . $quantity . "\n";
            echo $this->formatPrice($subtotal) . "\n";
        }
        
        echo "----------------------\n";
        echo "Total: " . $this->formatPrice($this->getTotal()) . "\n";

    }
}