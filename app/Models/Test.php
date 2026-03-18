<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lesson_id', 'number_of_questions'];

    public function lesson()
    {
        return $this->belongsTo(lesson::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }
    

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
