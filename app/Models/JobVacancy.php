<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
    'user_id', 'title', 'company', 'description', 
    'location', 'poster_image', 'category', 'is_active', 'expired_at'
];

/**
 * Relasi balik ke User (Bisa Admin atau Alumni)
 */
public function user()
{
    return $this->belongsTo(User::class);
}
}
