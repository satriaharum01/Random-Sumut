<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug'];

    // Validator
    public static function validate($data, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|unique:tags,slug,' . $id,
        ];

        $messages = [
            'name.required' => 'Judul wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    // Relasi: Tag bisa punya banyak artikel
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }
}
