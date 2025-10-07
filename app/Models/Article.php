<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'image', 'author_id', 'category_id', 'status', 'views'
    ];

    // Relasi: Artikel dimiliki oleh User (author/jurnalis)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Relasi: Artikel milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized'
        ]);
    }

    // Relasi: Artikel bisa punya banyak tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    // Relasi: Artikel bisa punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
