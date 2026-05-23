<?php

namespace App\Http\Controllers\Twill;

use App\Http\Controllers\Controller;
use App\Models\WritingPersona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use A17\Twill\Facades\TwillAppSettings;

class AiGenerateController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'persona_id' => 'required|exists:writing_personas,id',
            'action' => 'required|in:generate,restyle',
            'title' => 'required|string|max:500',
            'body' => 'nullable|string',
        ]);

        $apiKey = TwillAppSettings::get('siteSettings.analytics.claude_api_key');

        if (! $apiKey) {
            return response()->json([
                'error' => 'Claude API key not configured. Set it in Site Settings.',
            ], 422);
        }

        $persona = WritingPersona::findOrFail($request->persona_id);

        $userMessage = $request->action === 'generate'
            ? "Write an article with this title: \"{$request->title}\"\n\nWrite the full article body. Do not include the title in your response."
            : "Rewrite this article in your voice. Keep the same facts and structure but apply your writing style.\n\nTitle: \"{$request->title}\"\n\nCurrent draft:\n{$request->body}";

        try {
            $client = \Anthropic::factory()
                ->withApiKey($apiKey)
                ->make();

            $response = $client->messages()->create([
                'model' => 'claude-sonnet-4-6',
                'max_tokens' => 4096,
                'system' => $persona->voice_description,
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $text = $response->content[0]->text;

            return response()->json(['text' => $text]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Claude API error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
