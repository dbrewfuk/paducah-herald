<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;

class Article extends Model
{
    use HasSlug, HasMedias;

    protected $fillable = [
        'published',
        'title',
        'fly_title',
        'standfirst',
        'body',
        'section_id',
        'read_time',
        'publish_start_date',
        'hero_image_url',
    ];

    protected $casts = [
        'publish_start_date' => 'datetime',
    ];

    public $slugAttributes = ['title'];

    public $mediasParams = [
        'hero' => [
            'default' => [['name' => 'default', 'ratio' => 16 / 9]],
            'mobile'  => [['name' => 'mobile',  'ratio' => 1]],
        ],
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
