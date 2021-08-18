<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastSerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id',
        'title',
        'cover_art',
        'seasons',
        'subscription_type',
        'category',
        'description'
    ];
}
