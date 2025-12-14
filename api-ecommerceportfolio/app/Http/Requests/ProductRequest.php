<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'name' => 'sometimes|string',
        'description' => 'sometimes|string',
        'price' => 'sometimes|numeric',
        'inventoryStatus' => 'sometimes|string',
        'category' => 'sometimes|string',
        'imageUrl' => 'nullable|string',
        'storeId' => 'sometimes|integer',
        'currency' => 'sometimes|string',
    ];
    }

    public function toBackend(): array
{
    $data = $this->validated();

    return [
        'name' => $data['name'] ?? null,
        'description' => $data['description'] ?? null,
        'price' => $data['price'] ?? null,
        'inventory_status' => $data['inventoryStatus'] ?? null,
        'category' => $data['category'] ?? null,
        'image_url' => $data['imageUrl'] ?? null,
        'store_id' => $data['storeId'] ?? null,
        'currency' => $data['currency'] ?? null,
    ];
}
}
