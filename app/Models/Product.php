<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'description',
    ];

    protected $keyType = 'string';

    public $incrementing = false;


    protected static function booted()
    {
        static::creating(function($product){
            if (!$product->id) {
                $product->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    // Method untuk membuat produk baru
    public static function createProduct(array $data)
    {
        return self::create($data);
    }

    // Method untuk memperbarui produk
    public function updateProduct(array $data)
    {
        return $this->update($data);
    }

    // Method untuk menghapus produk
    public function deleteProduct()
    {
        return $this->delete();
    }
}
