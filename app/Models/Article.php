<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Automatically generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // Get route key name for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Get excerpt of content
    public function getExcerptAttribute()
    {
        return Str::limit($this->content, 150);
    }
}
