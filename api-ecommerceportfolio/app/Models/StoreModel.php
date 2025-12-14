<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreModel extends Model
{
    use HasFactory;
    protected $table = 'stores';

      protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'street_number',
        'street_name',
        'city',
        'state',
        'zip_code',
        'contact_phone',
        'image_url',
    ];
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'store_id');
    }
}
