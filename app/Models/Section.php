<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class Section extends Model implements Sortable
{
    use HasSlug, HasMedias, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
    ];

    public $slugAttributes = ['title'];

    public $mediasParams = [
        'hero' => [
            'default' => [['name' => 'default', 'ratio' => 21 / 8]],
        ],
    ];

    public function articles()
    {
        return $this->hasMany(Article::class)->orderByDesc('publish_start_date');
    }
}
