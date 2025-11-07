<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturedArticle extends Model
{
    use HasFactory;

    protected $table = 'featured';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug'];

    // Relasi: Tag bisa punya banyak artikel
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }
}
