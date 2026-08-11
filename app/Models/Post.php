<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'category_id',
        'views',
        'thumbnail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function scopePopular($query)
    // {
    //     return $query->orderBy('views', 'desc');
    // }
}
