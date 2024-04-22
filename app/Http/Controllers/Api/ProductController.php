<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsListResource;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all() ;
        return response()->json(ProductsListResource::collection($products),200) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $invalidRequestItems = false ;
        if($request->discountType=='percent') {
            if($request->discountValue < 1 || $request->discountValue > 99) {
                $errors = [
                    'discountValue' => ['Percentage must be between 0 and 99']
                ] ;
                $invalidRequestItems = true ;
            }
        } elseif($request->discountType=='amount') {
            if($request->discountValue > $request->price) {
                $errors = [
                    'discountValue' => ['Discount amount cannot be greater than price.']
                ] ;
                $invalidRequestItems = true ;
            }
        }

        if($invalidRequestItems) {
            return response()->json(['message'=>'The given data was invalid','errors'=>$errors],422) ;
        }

        $productDetails = [
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'active' => true,
        ] ;

        $insertedProduct = Product::create($productDetails) ;

        foreach ($request->images as $image) {
            $productImageDetails = [
                'path' => $image,
                'product_id' => $insertedProduct->id
            ] ;
            ProductImage::create($productImageDetails) ;
        }

        ProductDiscount::create([
            'type' => $request->discountType,
            'discount' => $request->discountValue,
            'product_id' => $insertedProduct->id
        ]);
        if(isset($insertedProduct->id)) {
            $message = 'Product Created' ;
            $statusCode = 201 ;
        } else {
            $message = 'Something Went Wrong' ;
            $statusCode = 500 ;
        }
        return response()->json(['message'=>$message],$statusCode) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($value)
    {
        $product = Product::where('slug', $value)->orWhere('id', $value)->first() ;
        if(!empty($product)) {
            $productDetails = new ProductResource($product) ;
            return response()->json($productDetails,200) ;
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        $invalidRequestItems = false ;
        if($request->discountType=='percent') {
            if($request->discountValue < 1 || $request->discountValue > 99) {
                $errors = [
                    'discountValue' => ['Percentage must be between 0 and 99']
                ] ;
                $invalidRequestItems = true ;
            }
        } elseif($request->discountType=='amount') {
            if($request->discountValue > $request->price) {
                $errors = [
                    'discountValue' => ['Discount amount cannot be greater than price.']
                ] ;
                $invalidRequestItems = true ;
            }
        }
        if($invalidRequestItems) {
            return response()->json(['message'=>'The given data was invalid','errors'=>$errors],422) ;
        }

        if(Product::where('id', $id)->count()==0) {
            return response()->json(['message'=>'Product Not Found'],404) ;
        }

        $productDetails = [
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
        ] ;

        $updateProduct = Product::where('id',$id)->update($productDetails) ;

        foreach ($request->images as $image) {
            $productImageDetails = [
                'path' => $image,
                'product_id' => $id
            ] ;
            ProductImage::create($productImageDetails) ;
        }

        ProductDiscount::where('product_id',$id)->update([
            'type' => $request->discountType,
            'discount' => $request->discountValue
        ]);
        if($updateProduct>0) {
            $message = 'Product Updated' ;
            $statusCode = 200 ;
        } else {
            $message = 'Something Went Wrong' ;
            $statusCode = 500 ;
        }
        return response()->json(['message'=>$message],$statusCode) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Product::where('id', $id)->count()==0) {
            return response()->json(['message'=>'Product Not Found'],404) ;
        }

        $deleteProduct = Product::find($id)?->delete() ;
        if($deleteProduct) {
            return response()->json(['message' => 'Product deleted'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
