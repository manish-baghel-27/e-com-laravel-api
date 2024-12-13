<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\Product;

class Tag extends Model
{
    use HasFactory;

    // posts
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    // porducts
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
