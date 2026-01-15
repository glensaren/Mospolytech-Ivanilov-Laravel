<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово присваивать
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'content',
    ];

    /**
     * Получить статью, к которой принадлежит комментарий
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Получить автора комментария
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}