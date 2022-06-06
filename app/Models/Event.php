<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = ['title', 'start', 'end', 'busNo', 'start_km', 'end_km', 'user_id', 'place_id', 'stopsNum'];
    public $hidden = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bus(){
        return $this->belongsTo(User::class, 'busNo');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }
}

