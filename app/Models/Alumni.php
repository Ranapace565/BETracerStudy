<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
    'user_id', 'nim', 'nik', 'npwp', 'name', 'phone_number', 
    'img_profile', 'privacy_settings', 'tahun_lulus', 'kdpstmsmh', 'status'
];

protected $casts = [
    'privacy_settings' => 'array', // Casting JSON ke Array
];

public function user()
{
    return $this->belongsTo(User::class);
}
}
