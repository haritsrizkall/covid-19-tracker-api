<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = ['person_id', 'longitude', 'latitude', 'date_time'];
    protected $table = 'positions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function person(){
        return $this->belongsTo(Person::class);
    }
}
