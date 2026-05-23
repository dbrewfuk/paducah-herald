<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class WorldInBrief extends Model
{
    use HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'region',
        'body',
        'publish_start_date',
    ];

    protected $casts = [
        'publish_start_date' => 'datetime',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [['name' => 'default', 'ratio' => 16 / 9]],
        ],
    ];
}
