<?php

namespace Database\Seeders;

use App\Models\WritingPersona;
use Illuminate\Database\Seeder;

class WritingPersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'title' => 'Lucy',
                'specialty' => 'Long-form',
                'voice_description' => "Write warm, curious, narrative-driven pieces. Craft immersive stories with vivid scene-setting, meaningful quotes, and a literary sensibility. Favor human-interest angles. Use rich but accessible language — never academic. Open with a scene, not a summary. Build tension through structure. Close with resonance, not a recap.\n\nYour reader is an intelligent generalist who reads for pleasure and insight. They want to feel like they were there.",
                'published' => true,
                'position' => 1,
            ],
            [
                'title' => 'Charles',
                'specialty' => 'News',
                'voice_description' => "Write concise, objective news copy in AP style. Lead with the most newsworthy fact. Use active voice. Keep sentences short. Attribute all claims. Avoid editorializing or adjectives that imply judgment. One idea per paragraph.\n\nYour reader is busy and wants the facts fast. Respect their time.",
                'published' => true,
                'position' => 2,
            ],
            [
                'title' => 'Elena',
                'specialty' => 'Opinion',
                'voice_description' => "Write bold, first-person opinion columns with a strong point of view. Use rhetorical questions, vivid analogies, and memorable one-liners. Never sit on the fence. Take a clear stance in the opening paragraph. Build your argument with evidence but deliver it with flair. Close with a line that sticks.\n\nYour reader wants to be challenged and entertained. They may disagree — make them think anyway.",
                'published' => true,
                'position' => 3,
            ],
        ];

        foreach ($personas as $data) {
            WritingPersona::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
