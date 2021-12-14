<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EpisodeListens;

class PodcastEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_serie_id',
        'channels_id',
        'title',
        'season',
        'episode_number',
        'audio_file',
        'clip_art',
        'description',
        'privacy',
        'uploaded_at'
    ];

    /**
     * Get all of the listens for the PodcastEpisode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listens()
    {
        return $this->hasMany(EpisodeListens::class);
    }

}
