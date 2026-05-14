<?php

namespace Database\Seeders;

use App\Enums\ConceptDifficulty;
use App\Enums\ConceptStatus;
use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class ConceptSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Laravel' => [
                [
                    'title' => 'Eloquent N+1 Problem',
                    'explanation' => 'When loading related models in loops without eager loading, the app triggers many SQL queries and degrades performance.',
                    'difficulty' => ConceptDifficulty::Mid,
                    'status' => ConceptStatus::InProgress,
                ],
                [
                    'title' => 'Service Container',
                    'explanation' => 'Laravel service container resolves dependencies and supports dependency injection in controllers and services.',
                    'difficulty' => ConceptDifficulty::Senior,
                    'status' => ConceptStatus::ToReview,
                ],
            ],
            'PHP OOP' => [
                [
                    'title' => 'Interfaces vs Abstract Classes',
                    'explanation' => 'Interfaces define contracts while abstract classes share partial implementations between related classes.',
                    'difficulty' => ConceptDifficulty::Junior,
                    'status' => ConceptStatus::Mastered,
                ],
            ],
            'MySQL' => [
                [
                    'title' => 'Indexing Basics',
                    'explanation' => 'Indexes improve query performance by reducing scanned rows, but add write overhead.',
                    'difficulty' => ConceptDifficulty::Mid,
                    'status' => ConceptStatus::InProgress,
                ],
            ],
            'API REST' => [
                [
                    'title' => 'HTTP Status Codes',
                    'explanation' => 'Use semantically correct status codes to communicate outcomes: 200, 201, 204, 400, 401, 403, 404, 422, 500.',
                    'difficulty' => ConceptDifficulty::Junior,
                    'status' => ConceptStatus::Mastered,
                ],
            ],
        ];

        foreach ($map as $domainName => $concepts) {
            $domain = Domain::where('name', $domainName)->first();

            if (! $domain) {
                continue;
            }

            foreach ($concepts as $payload) {
                Concept::updateOrCreate(
                    ['domain_id' => $domain->id, 'title' => $payload['title']],
                    [
                        'explanation' => $payload['explanation'],
                        'difficulty' => $payload['difficulty']->value,
                        'status' => $payload['status']->value,
                    ]
                );
            }
        }
    }
}
