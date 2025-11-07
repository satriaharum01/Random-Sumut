<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'slug', 'content', 'image', 'author_id', 'category_id', 'status', 'views'
    ];

    // Validator
    public static function validate($data, $id = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'content' => 'required|string',
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' : 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'views' => 'nullable|integer|min:0',
        ];

        $messages = [
            'title.required' => 'Judul wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'content.required' => 'Konten wajib diisi.',
            'image.required' => 'Gambar wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'author_id.required' => 'Penulis wajib diisi.',
        ];

        return Validator::make($data, $rules, $messages);
    }

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
