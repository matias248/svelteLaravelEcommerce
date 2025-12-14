<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'inventory_status',
        'category',
        'image_url',
        'store_id',
        'currency',
    ];

    protected $casts = [
        'price' => 'float',
        'inventory_status' => 'string',
        'category' => 'string',
        'currency' => 'string',
    ];

    public function store()
    {
        return $this->belongsTo(StoreModel::class, 'store_id');
    }
}