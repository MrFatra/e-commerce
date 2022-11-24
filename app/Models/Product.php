<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'tags',
        'categories_id',
    ];

    public function productGalleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'categories_id', 'id');
    }
}
