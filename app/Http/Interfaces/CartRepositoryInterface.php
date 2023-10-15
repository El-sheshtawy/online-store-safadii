<?php

namespace App\Http\Interfaces;

use App\Models\Product;


interface CartRepositoryInterface
{
    public function get();

    public function add(Product $product, int $quantity = 1);

    public function update($id, int $quantity);

    public function delete($id);

    public function empty();

    public function total(): float;

    public function totalByMySql(): float;          // function with mysql way to calculate total items prices
}
