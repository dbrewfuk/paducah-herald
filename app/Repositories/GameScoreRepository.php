<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\GameScore;

class GameScoreRepository extends ModuleRepository
{
    public function __construct(GameScore $model)
    {
        $this->model = $model;
    }
}
