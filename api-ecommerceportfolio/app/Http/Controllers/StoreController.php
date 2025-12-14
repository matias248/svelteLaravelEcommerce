<?php

namespace App\Http\Controllers;

use App\Models\StoreModel;
use Illuminate\Http\Request;

use App\Http\Resources\StoreResource;

class StoreController extends Controller
{
    // Crear tienda
    public function createStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location.latitude' => 'required|numeric',
            'location.longitude' => 'required|numeric',
            'address.streetNumber' => 'required|string',
            'address.streetName' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'address.zipCode' => 'required|string',
            'contactPhone' => 'required|string',
            'imageUrl' => 'nullable|string',
        ]);

        $store = StoreModel::create([
            'name' => $request->name,
            'latitude' => $request->input('location.latitude'),
            'longitude' => $request->input('location.longitude'),
            'street_number' => $request->input('address.streetNumber'),
            'street_name' => $request->input('address.streetName'),
            'city' => $request->input('address.city'),
            'state' => $request->input('address.state'),
            'zip_code' => $request->input('address.zipCode'),
            'contact_phone' => $request->contactPhone,
            'image_url' => $request->imageUrl ?? " ",
        ]);
        $storeR=  new StoreResource($store);
        return response()->json( $storeR, 201);
    }

    public function listStores(Request $request)
    {
            $text = $request->query('textfilter');

            if ($text) {
                $text = strtolower($text);
                $stores = StoreModel::where(function ($q) use ($text) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$text}%"])
                    ->orWhereRaw('LOWER(city) LIKE ?', ["%{$text}%"])
                    ->orWhere('zip_code', 'LIKE', "%{$text}%");
                })->get();

            } else {
                $stores = StoreModel::all();
            }
            $storesR = StoreResource::collection($stores);
            return response()->json($storesR
            ,200);
    }

    public function getStore($id)
    {
        $store = StoreModel::find($id);
        if (!$store) {
            return response()->json([
                'message' => 'Store not found',
                'status' => 404
            ], 404);
        }
        $storeR=  new StoreResource($store);

        return response()->json($storeR
        ,200);
    }

    public function deleteStore($id)
    {
        $store = StoreModel::find($id);
        if (!$store) {
            return response()->json([
                'message' => 'Store not found',
                'status' => 404
            ], 404);
        }
        $storeR=  new StoreResource($store);

        $store->delete();

        return response()->json(['message'=>'store deleted'], 200);
    }

    public function updateStore(Request $request, $id)
    {
        $store = StoreModel::find($id);
        if (!$store) {
            return response()->json([
                'message' => 'Store not found',
                'status' => 404
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'location.latitude' => 'sometimes|numeric',
            'location.longitude' => 'sometimes|numeric',
            'address.streetNumber' => 'sometimes|string',
            'address.streetName' => 'sometimes|string',
            'address.city' => 'sometimes|string',
            'address.state' => 'sometimes|string',
            'address.zipCode' => 'sometimes|string',
            'contactPhone' => 'sometimes|string',
            'imageUrl' => 'nullable|string',
        ]);

        if ($request->has('name')) $store->name = $request->name;
        if ($request->has('location.latitude')) $store->latitude = $request->input('location.latitude');
        if ($request->has('location.longitude')) $store->longitude = $request->input('location.longitude');
        if ($request->has('address.streetNumber')) $store->street_number = $request->input('address.streetNumber');
        if ($request->has('address.streetName')) $store->street_name = $request->input('address.streetName');
        if ($request->has('address.city')) $store->city = $request->input('address.city');
        if ($request->has('address.state')) $store->state = $request->input('address.state');
        if ($request->has('address.zipCode')) $store->zip_code = $request->input('address.zipCode');
        if ($request->has('contactPhone')) $store->contact_phone = $request->contactPhone;
        if ($request->has('imageUrl')) $store->image_url = $request->imageUrl;

        $store->save();
        $storeR=  new StoreResource($store);

        return response()->json($storeR,200);
    }

    

}