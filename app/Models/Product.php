<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','slug','price','compare_price',
        'description','brand','image','stock','status','is_featured'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function avgRating()
    {
        return $this->reviews()->where('status', 1)->avg('rating');
    }

    
}
