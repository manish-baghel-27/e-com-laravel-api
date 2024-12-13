<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Tag;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    // tags
    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
