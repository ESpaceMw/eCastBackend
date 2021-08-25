<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PodcastSerie;
use App\Models\PodcastEpisode;
use App\Models\Subscribers;

class Channels extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'cover_art',
        'description'
    ];

    public function subscribers()
    {
        return $this->hasMany(Subscribers::class);
    }

    public function series()
    {
        return $this->hasMany(PodcastSerie::class);
    }

    public function episodes()
    {
        return $this->hasMany(PodcastEpisode::class);
    }

}
