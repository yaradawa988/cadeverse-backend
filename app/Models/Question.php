<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'question_text',
         'question_type',
         'options',
        'correct_answer',
         'answer',
         'mark',
         
     ];

     public function test()
     {
         return $this->belongsTo(Test::class, 'test_id');
     }
     
     public function student_answers()
     {
         return $this->hasMany(student_answer::class);
     }

     public function getOptionsAttribute($value)
{
    return json_decode($value, true);
}

public function setOptionsAttribute($value)
{
    $this->attributes['options'] = json_encode($value, JSON_UNESCAPED_UNICODE);
}
}
