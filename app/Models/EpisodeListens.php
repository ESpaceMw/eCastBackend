<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PodcastEpisode;

class EpisodeListens extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_serie_id',
        'user_id',
        'podcast_episode_id'
    ];

    public function listens()
    {
        return $this->belongsTo(PodcastEpisode::class);
    }
}
