<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Product;

class ProductBuyerTransactionController extends ApiController
{
 public function __construct()
    {
    }
    
     public function store(Request $request , Product $product , User $byuer){
       
        if(!$byuer->id == $product_seller_id)
        {
            return $this->errorResponse('the buyer must be differnt from the seller' , 409);
        }
        if(!$byuer->isVerified())
        {
          return $this->errorResponse('the seller must be a verified user' , 409);

        }
         if(!$product->seller->isVerified())
        {
        return $this->errorResponse('the seller must be a verified user' , 409);

        }
        if(!$product->isAvailable())
        {
        return $this->errorResponse('the product is not ' , 409);

        }
        if($product->quantity < $request->quantity){
        return $this->errorResponse('the product does not have enough units for thi transaction' , 409);
        }
        
       return DB::transaction(function () use ($product ,$request ,$byuer ) {
          $product->quantity -= $request->quantity;
          $product->save();
          
          $transaction = Transaction::create([
            'quantity' => $request->quantity,
            'byuer_id' => $request->byuer_id,
            'product_id' => $request->product_id,
          ]);
          
          return $this->showOne($transaction);
      });
    }
}