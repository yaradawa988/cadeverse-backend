<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table ='checks';
    protected $fillable = [
        'user_id',
        'message',
        'result',
        'status',
        
    ];

	 public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
