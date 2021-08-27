<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListenersReviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'channels_id',
        'reviewer_name',
        'reviewer_avatar',
        'review',
        'stars'
    ];
}
