<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'product_image',
    ];

    /**
     * @param $image
     * @return string
     */
    public function getProductImageAttribute($image): string {
        return asset('storage/' . $image);
    }

    protected static function boot() {
        parent::boot();
        self::saved(function (Product $product) {
            if (request()->hasFile('product_image')) {
                Product::withoutEvents(function () use ($product) {
                    $oldImage = $product->getOriginal('product_image');
                    $image = request()->file('product_image')->store('products');

                    $product->product_image = $image;
                    $product->save();

                    if ($oldImage) {
                        Storage::delete($oldImage);
                    }
                });
            }
        });

        self::deleted(function (Product $product) {
            $oldImage = $product->getOriginal('product_image');
            if ($oldImage) {
                Storage::delete($oldImage);
            }
        });
    }
}
