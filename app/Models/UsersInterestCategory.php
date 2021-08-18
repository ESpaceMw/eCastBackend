<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersInterestCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'users_interest_category_id',
    ];

}
