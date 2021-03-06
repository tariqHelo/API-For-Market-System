<?php

namespace App\Http\Controllers\Buyer;
use App\Buyer;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
    public function __construct()
    {
    }
    public function index(Buyer $buyer){
        
      $transaction = $buyer->transaction;
      return $this->showAll($transaction);
    }
}