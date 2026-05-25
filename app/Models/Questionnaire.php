<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    // use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'is_active',
    ];

    /**
     * Relasi ke daftar pertanyaan (One-to-Many).
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
