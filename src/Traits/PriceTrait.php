<?php

namespace RestaurantManagement\Traits;

trait PriceTrait {
    public function formatPrice($price) {
        return "Rp " . number_format($price, 0, ',', '.');
    }


}