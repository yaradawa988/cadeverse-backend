<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'completed_at',
        ];
    
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
    
        public function test()
        {
            return $this->belongsTo(Test::class);
        }
        protected $dates = ['completed_at'];
        
}
