<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Tag;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;


    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // images
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // tags
    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * The categories that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
}
