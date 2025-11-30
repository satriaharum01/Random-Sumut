<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['article_id', 'user_id', 'content', 'status'];

    // Relasi: Komentar milik artikel
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Relasi: Komentar ditulis user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
