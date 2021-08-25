<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PodcastEpisode;

class PodcastSerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_serie_id',
        'channels_id',
        'title',
        'cover_art',
        'seasons',
        'subscription_type',
        'category',
        'description'
    ];

    /**
     * Get all of the podcastEpisodes for the PodcastSerie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function podcastEpisodes()
    {
        return $this->hasMany(PodcastEpisode::class, 'podcast_serie_id');
    }
}
