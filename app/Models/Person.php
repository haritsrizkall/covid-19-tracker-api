<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $fillable = ['name', 'gender', 'age', 'person_condition'];
    protected $table = 'persons';
    protected $primaryKey = 'id';
    public $timestamp = true;

    public function position(){
        return $this->hasMany(Position::class);
    }
}
