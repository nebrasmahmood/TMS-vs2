<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDatesPlaces extends Model
{
    use HasFactory;
    protected $table = 'working_dates_places';
    protected $fillable = ["user_id", 'place_id', 'date', "stops_no", 'AnotherstopsNo',
        "busNo", "cube_no", "percentage", "notes", "helper_id"];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function helper(){
        return $this->belongsTo(User::class, 'helper_id');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }
}
