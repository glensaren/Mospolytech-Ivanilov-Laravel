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
        'short_description',
        'author',
        'publication_date',
        'category',
        'preview_image',
        'is_published',
        'views_count',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->publication_date->format('d.m.Y');
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 200);
    }

    /**
     * Получить комментарии для статьи
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}