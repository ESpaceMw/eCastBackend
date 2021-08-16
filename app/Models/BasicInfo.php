<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'clip_art',
        'podcast_url',
        'title',
        'tagline',
        'description',
        'category',
        'language'
    ];
}
