<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    use HasFactory;

    protected $table = 'user_wishlist';

    protected $fillable = [
        "user_id",
        "product_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}