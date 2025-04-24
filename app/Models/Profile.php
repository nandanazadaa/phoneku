<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'profile_id'; // Matches the validator in your controller

    protected $fillable = [
        'user_id',
        'username',
        'phone',
        'gender',
        'birth_day',
        'birth_month',
        'birth_year',
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}