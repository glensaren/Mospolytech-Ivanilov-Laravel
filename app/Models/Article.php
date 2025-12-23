<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово присваивать
     *
     * @var array<int, string>
     */
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

    /**
     * Атрибуты, которые должны быть приведены к определенным типам
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Получить отформатированную дату публикации
     */
    public function getFormattedDateAttribute()
    {
        return $this->publication_date->format('d.m.Y');
    }

    /**
     * Получить сокращенное содержание (первые 200 символов)
     */
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 200);
    }
}