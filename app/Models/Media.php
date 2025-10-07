<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'file_type', 'uploaded_by'];

    // Relasi: Media diupload oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
