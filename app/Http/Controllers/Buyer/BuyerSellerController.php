<?php

namespace App\Http\Controllers\Buyer;
use App\Product;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
       public function __construct()
       {
       }
       public function index(Buyer $buyer){
            $sellers = $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
            return $this->showAll($sellers);
       }
}