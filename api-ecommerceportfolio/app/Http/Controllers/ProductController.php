<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\StoreModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StoreResource;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    //
    public function createProduct(Request $request,$store_id){
         $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'inventoryStatus' => 'required|string',
            'category' => 'required|string',
            'imageUrl' => 'nullable|string',
            'currency' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 405,
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 405);
        }
        $store = StoreModel::find($store_id);
        if (!$store) {
            return response()->json([
                'message' => 'Store not found',
                'status' => 404
            ], 404);
        }

        $validated = $validator->validated();
        
        $product = ProductModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'price'=>$request->price,
            'inventory_status' => $request->inventoryStatus,
            'category' => $request->category,
            'image_url' => $request->imageUrl,
            'store_id' => $store_id,
            'currency' => $request->currency,
        ]);

        if($product){
            $productR = new ProductResource($product);
            return response()->json($productR,201);
        }
        
        return response()->json([
            'product' => 'Product could not ve created',
            'status' => 500
        ],500);
    }

    public function listProducts(Request $request,$store_id)
{
    $store = StoreModel::find($store_id);

    if (!$store) {
        return response()->json([
            'message' => 'Store not found',
            'status' => 404
        ], 404);
    }
    $includeStore = $request->query('storedata') === 'true';
    
    $products = ProductModel::where('store_id', $store_id)->get();
    $productsR = ProductResource::collection($products);

     if ($includeStore) {
           if($store){
            $storeR=  new StoreResource($store);
            return response()->json(['products'=>$productsR,'store'=>$storeR],200);
           }
           else{
                return response()->json(['message'=>'Store not found'],404);
           }
        }
    return response()->json($productsR, 200);
}

    public function getProduct(Request $request,$store_id, $id)
    {
        $includeStore = $request->query('storedata') === 'true';

        $product = ProductModel::where('store_id',$store_id)->find($id);
        if(!$product){
            return response()->json(['message'=>'Product or store not found','status'=>404],404);
        }
        $productR = new ProductResource($product);

        if ($includeStore) {
           $store = StoreModel::find($product->store_id);
           $storeR =  new StoreResource($store);

           if($store){
            return response()->json(['product'=>$productR,'store'=>$storeR],200);
           }
           else{
                return response()->json(['message'=>'Store not found'],404);
           }
        }
        return response()->json($productR,200);
    }

    public function updateProduct(Request $request, $store_id, $id)
    {
        $product = ProductModel::where('store_id', $store_id)->find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 404
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'inventoryStatus' => 'sometimes|string',
            'category' => 'sometimes|string',
            'imageUrl' => 'nullable|string',
            'currency' => 'sometimes|string',
        ]);

        if ($request->has('name')) $product->name = $request->name;
        if ($request->has('description')) $product->description = $request->description;
        if ($request->has('price')) $product->price = $request->price;
        if ($request->has('inventoryStatus')) $product->inventory_status = $request->inventoryStatus;
        if ($request->has('category')) $product->category = $request->category;
        if ($request->has('imageUrl')) $product->image_url = $request->imageUrl;
        if ($request->has('currency')) $product->currency = $request->currency;

        $product->save();
        $productR = new ProductResource($product);


        return response()->json($productR, 200);
    }

    public function deleteProduct($store_id,$id){
        $product = ProductModel::where('store_id',$store_id)->find($id);
        if(!$product){
            return response()->json(['message'=>'Product not found','status'=>404],404);
        }  
        $productR = new ProductResource($product);

        $product->delete();

        return response()->json(['message'=>'deleted','status'=>200],200);

      }
      
    public function publicProducts(Request $request)
    {
        $text = $request->query('textfilter'); 
        $storeId = $request->query('storeid'); 
        $categories = $request->query('categories'); 
        $page = $request->query('page'); 
        $pageLength = $request->query('pagelength'); 

        $query = ProductModel::query();
        $query->where('inventory_status', '<>', 'OUTOFSTOCK');

        if ($text) {
            $query->where(function($q) use ($text) {
                $q->where('name', 'like', '%' . $text . '%')
                ->orWhere('description', 'like', '%' . $text . '%');
            });
        }

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        if ($categories) {
            $categoriesArray = array_map('trim', explode(',', $categories));
            $query->whereIn('category', $categoriesArray);
        }

        if (!$page || !$pageLength) {
            $products = $query->get();
            $productsR = ProductResource::collection($products);

            return response()->json([
                'totalPages' => 1,
                'products' => $productsR,
            ]);
        }

        $page = (int) $page;
        $pageLength = (int) $pageLength;
        $total = $query->count();
        $products = $query->skip(($page - 1) * $pageLength)
                        ->take($pageLength)
                        ->get();
        $totalPages = ceil($total / $pageLength);
        
        $productsR = ProductResource::collection($products);

        return response()->json([
            'products' => $productsR,
            'totalPages' => $totalPages,
        ]);
    }


}
