<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class InsiderEpisode extends Model
{
    use HasSlug, HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'episode_summary',
        'sponsor_name',
        'video_url',
        'publish_start_date',
    ];

    protected $casts = [
        'publish_start_date' => 'datetime',
    ];

    public $slugAttributes = ['title'];

    public $mediasParams = [
        'thumbnail' => [
            'default' => [['name' => 'default', 'ratio' => 16 / 9]],
        ],
        'sponsor_logo' => [
            'default' => [['name' => 'default', 'ratio' => 0]],
        ],
    ];
}
