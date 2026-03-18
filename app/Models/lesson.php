<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'description'];

    public function contents()
    {
        return $this->hasMany(LessonContent::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
