<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'views', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function incrementViews()
    {
        $this->increment('views');

        Cache::increment("post_{$this->id}_views");
    }

    public function getViewsAttribute()
    {
        return Cache::remember("post_{$this->id}_views", now()->addMinutes(10), function() {
            return $this->attributes['views'];
        });
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
