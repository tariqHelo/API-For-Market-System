<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductCategoryController extends ApiController
{
     public function __construct()
    {
    }

    public function index(Product $product){
      
        $categories = $product->categories;

        return $this->showAll($categories);
    }

    public function update(Request $request , Product $product , Category $category){
     
        $product->category()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->category);

    }

    public function destroy( Product $product , Category $category){
        
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('The specified is not a category of this product' , 404);
        }

        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);

    }
}
