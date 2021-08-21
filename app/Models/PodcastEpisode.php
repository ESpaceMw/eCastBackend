<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_serie_id',
        'title',
        'season',
        'episode_number',
        'audio_file',
        'clip_art',
        'description',
        'privacy',
        'uploaded_at'
    ];

}
