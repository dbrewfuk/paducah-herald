<?php

use A17\Twill\Facades\TwillRoutes;
use App\Http\Controllers\Twill\AiGenerateController;

// Register Twill routes here eg.
// TwillRoutes::module('posts');

TwillRoutes::module('articles');
TwillRoutes::module('writingPersonas');

Route::prefix('admin')
    ->middleware(['twill_auth:twill_users'])
    ->group(function () {
        Route::post('ai/generate', AiGenerateController::class)->name('twill.ai.generate');

        Route::get('api/writing-personas', function () {
            $personas = \App\Models\WritingPersona::where('published', true)
                ->ordered()
                ->get()
                ->map(function ($persona) {
                    return [
                        'id' => $persona->id,
                        'title' => $persona->title,
                        'specialty' => $persona->specialty,
                        'voice_description' => $persona->voice_description,
                        'avatar_url' => $persona->hasImage('avatar') ? $persona->image('avatar', 'default') : null,
                    ];
                });
            return response()->json($personas);
        })->name('twill.api.writing-personas');
    });
TwillRoutes::module('sections');
TwillRoutes::module('weeklyEditions');
TwillRoutes::module('worldInBriefs');
TwillRoutes::module('insiderEpisodes');
TwillRoutes::module('gameScores');