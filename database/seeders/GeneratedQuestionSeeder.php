<?php

namespace Database\Seeders;

use App\Models\Concept;
use App\Models\GeneratedQuestion;
use Illuminate\Database\Seeder;

class GeneratedQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $concept = Concept::where('title', 'Eloquent N+1 Problem')->first();

        if (! $concept) {
            return;
        }

        GeneratedQuestion::updateOrCreate(
            ['concept_id' => $concept->id, 'provider' => 'groq', 'model' => 'llama-3.1-8b-instant'],
            [
                'questions' => [
                    'What is the N+1 problem in ORM systems and why does it happen?',
                    'How do you detect N+1 queries in a Laravel application?',
                    'What is eager loading and when should you use it?',
                    'Explain the difference between with() and load() in Eloquent.',
                    'How can N+1 issues affect response time in production APIs?',
                ],
            ]
        );
    }
}
