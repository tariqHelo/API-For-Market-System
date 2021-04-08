<?php

namespace App\Http\Controllers\Seller;
use App\Seller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{

    public function __construct()
    {

    }
    public function index(Seller $seller){
     $transactions = $seller->products()
     ->whereHas('transactions')
     ->with('transactions')
     ->get()
     ->pluck('transactions')
     ->collapse();

     return $this->showAll($transactions);
    }
}