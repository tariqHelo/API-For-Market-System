<?php

namespace App\Http\Controllers\Seller;
use App\Seller;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    
    public function __construct()
    {
    }

    public function index(Seller $seller){
        $categories = $seller->products()
        ->whereHas('categories')
        ->with('categories')
        ->get()
        ->pluck('categories')
        ->collapse()
        ->unique('id')
        ->values();

        return $this->showAll($categories);
    }
}