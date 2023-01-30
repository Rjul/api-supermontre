<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function scopeOwnedBy(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createForUser(User $user)
    {
        if ($user->products->isEmpty()) {
            return false;
        }

        $this->user_id = $user->id;
        $this->products = function () use ($user) {
            $products = [];
            foreach ($user->products as $product) {
                $product->quantity = $product->pivot->quantity;
                $products[] = $product;
            }
            return collect($products)->toArray();
        };
        $this->total_price = function () use ($user) {
            $total = 0;
            foreach ($user->products as $product) {
                $total += $product->price * $product->pivot->quantity;
            }
            return $total;
        };
        $this->save();
    }

    protected $fillable = [
        'user_id',
        'products',
        'total_price'
    ];

}
