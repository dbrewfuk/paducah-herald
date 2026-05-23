<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;

class WritingPersona extends Model
{
    use HasMedias, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'specialty',
        'voice_description',
        'position',
    ];

    public $mediasParams = [
        'avatar' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];
}
