<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{
    public function __construct()
    {

    }

    public function index(Product $product){

       //dd(20); 

        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }
}
