<?php

namespace App\Http\Controllers\Seller;
use App\Seller;
use App\User;
use App\Product;

use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{
        public function __construct()
        {
        }
        public function index(Seller $seller)
        {

            $products = $seller->products;

            return $this->showAll($products);
            
        }
        public function store(Request $request , User $seller){
     
            $rules = [
             
                'name' => "required",
                'description' => "required",
                'quantity' => "required|integer|min:1",
                'image' => "required|image"
            ];
            $this->validate($request , $rules);

          $data = $request->all();

          $data['status'] = Product::UNAVAILABLE_PRODUCT;
          $data['image'] = '1.jpg';
          $data['seller_id'] = $seller->id;
          
          $product = Product::create($data);

          return $this->showOne($product);
        }


    public function update(Request $request , Seller $seller , Product $product){

           $rules = [
               'quantity' => "integer|min:1",
                'status' => 'in:' . Product::UNAVAILABLE_PRODUCT . ',' . Product::AVAILABLE_PRODUCT,
                'image' => 'image',
            ];

        $this->validate($request , $rules);

        $this->ckeckSeller($seller,  $product );
         
        $product->fill($request->intersect([
           'name',
           'description',
           'quantity'
        ]));

        if($request->has('status')){
            $product->status = $request->status;

            if($product->isAvailable && $product->categories()->count == 0){
               return $this->errorResponse('an Active product must have at least one category' , 409);
            }
        }

        if($product->isClean()){
           return $this->errorResponse('you need specify a differnt value to update' , 422);

        }

        $product->save();

        return $this->showOne($product);
    }

  

    public function distroy(Seller $seller , Product $product){

        $this->ckeckSeller($seller , $product);
         
        $product->delete();

        return $this->showOne($product);
    }


    protected function ckeckSeller(Seller $seller , Product $product){
        if($seller->id != $product->seller_id){
           throw new HttpException(422 , 'the specify seller is not the actual seller of the product');
        }
    }

}