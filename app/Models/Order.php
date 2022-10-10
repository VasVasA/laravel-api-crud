<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'client_name',
        'address',
        'user_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products', 'orders_id', 'products_id')->withPivot('count');
    }

    /**
     * @return int
     */
    public function price(): int
    {
        $price = 0;
        /** @var Product $product */
        foreach ($this->products as $product) {
            $price += $product->price * $product->pivot->count;
        }

        return $price;
    }
}
