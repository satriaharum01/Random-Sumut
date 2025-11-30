<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug'];

    // Validator
    public static function validate($data, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
        ];

        $messages = [
            'name.required' => 'Judul wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    // Relasi: Category punya banyak artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
