<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\WritingPersona;

class WritingPersonaRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(WritingPersona $model)
    {
        $this->model = $model;
    }
}
