<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsentUser extends Model
{
    use HasFactory;
    protected $table = 'absencese';
    protected $fillable = ['date', 'user_id', 'reason'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
