<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class WeeklyEdition extends Model
{
    use HasSlug, HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'edition_date',
        'publish_start_date',
    ];

    protected $casts = [
        'edition_date'        => 'date',
        'publish_start_date'  => 'datetime',
    ];

    public $slugAttributes = ['title'];

    public $mediasParams = [
        'cover' => [
            'default' => [['name' => 'default', 'ratio' => 3 / 4]],
        ],
    ];
}
