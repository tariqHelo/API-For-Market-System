<?php

namespace App\Http\Controllers\Category;
use App\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
{
      public function __construct()
      {

      }


    public function index(Category $category)
    {
        $sellers = $category->product()
        ->with('seller')
        ->get()
        ->pluck('seller')
        ->unique();

        return $this->showAll($sellers);
    }

}