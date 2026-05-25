<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id', 'alumni_id', 'question_option_id', 'answer_text'];

    public function alumni() { 
        return $this->belongsTo(Alumni::class); 
        }

    public function question()
{
    return $this->belongsTo(Question::class);
}

public function questionOption()
{
    return $this->belongsTo(QuestionOption::class, 'question_option_id');
}
}


