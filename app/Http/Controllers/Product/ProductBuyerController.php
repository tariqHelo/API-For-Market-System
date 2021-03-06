<?php

namespace App\Http\Controllers\Product;
use App\Product;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
     public function __construct()
    {
    }

    public function index(Product $product){
        $buyers = $product->transactions()
        ->with('buyer')
        ->get()
        ->pluck('buyer')
        ->unique('id')
        ->values();

        return $this->showAll($buyers);
    }
}
