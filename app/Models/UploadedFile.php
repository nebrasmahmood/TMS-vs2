<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;
    protected $table = 'uploadedfiles';
    protected $fillable = ['admin_id', 'user_id', 'file_path', 'file_name'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

