<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kls()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    public function surats()
    {
        return $this->belongsToMany(Surat::class);
    }

    public function psychologist()
    {
        return $this->hasMany(Psychologist::class);
    }

    public function tahsins()
    {
        return $this->hasMany(Tahsin::class);
    }
}
