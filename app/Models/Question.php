<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['questionnaire_id', 'parent_id', 'kode', 'text', 'type', 'order', 'is_required'];

public function questionnaire() {
    return $this->belongsTo(Questionnaire::class);
}

// Relasi untuk pertanyaan bercabang
public function children() {
    return $this->hasMany(Question::class, 'parent_id');
}

public function parent() {
    return $this->belongsTo(Question::class, 'parent_id');
}

public function options()
{
    return $this->hasMany(QuestionOption::class, 'question_id')->orderBy('order', 'asc');
}
}
