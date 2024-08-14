<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'productid',
        'uuid',
        'product_barcode',
        'product_name',
        'description',
        'product_image',
        'original_price',
        'sell_price',
        'discount',
        'categoryid',
        'brand',
        'supplier',
        'quantity',
        'is_new',
        'is_on_discount',
    ];
    protected $casts = [
        'is_new' => 'boolean',
        'is_on_discount' => 'boolean',
        'original_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->productid = self::generateUniqueIdentifier();
            if (!$product->uuid) {
                $product->uuid = (string) Str::uuid(); // Generate UUID if not set
            }
        });

    }

    /**
     * Generate a unique identifier.
     *
     * @return string
     */
    public static function generateUniqueIdentifier()
    {
        do {
            $identifier = 'P' .strtoupper(Str::random(5));
        } while (self::where('productid', $identifier)->exists());

        return $identifier;
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryid', 'categoryid');
    }
}
