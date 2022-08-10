<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dhuha extends Model
{
    use HasFactory;

    public $guarded = [];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
