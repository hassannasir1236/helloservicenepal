<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'ratings',
        'seller_id',
        'buyer_id',
        'item_id'
    ];

     public function seller() {
         return $this->belongsTo(User::class,'seller_id');
     }

    public function buyer() {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function item() {
        return $this->belongsTo(User::class);
    }

}
