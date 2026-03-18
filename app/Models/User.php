<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'l_name',
        'email',
        'password',
        'image',
        'role',
        'university',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        switch ($this->role){
            case 0:
                return "User";
                break;
            case 1:
                return "Admin";
                break;
        }
        return "No such Role";
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function Check()
        {
            return $this->hasMany(Check::class);
     
        }
        public function tests()
        {
            return $this->hasMany(Test::class, 'user_id');
        }

       public function progressTrackings() { return $this->hasMany(ProgressTracking::class); }


      public function monthlyStatistics() { return $this->hasMany(MonthlyStatistic::class); }
      public function favorites() { return $this->hasMany(Favorite::class); }
      public function lessons()
      {
          return $this->belongsToMany(lesson::class);
      }
      
}

