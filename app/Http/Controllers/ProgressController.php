<?php

namespace App\Http\Controllers;

use App\Enums\ConceptStatus;
use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function __invoke(): View
    {
        $userId = Auth::id();

        $domains = Domain::query()
            ->where('user_id', $userId)
            ->withCount([
                'concepts',
                'concepts as mastered_concepts_count' => fn ($query) => $query->where('status', ConceptStatus::Mastered->value),
                'concepts as in_progress_concepts_count' => fn ($query) => $query->where('status', ConceptStatus::InProgress->value),
                'concepts as to_review_concepts_count' => fn ($query) => $query->where('status', ConceptStatus::ToReview->value),
            ])
            ->latest()
            ->get();

        $statusCounts = [
            'mastered' => Concept::query()->where('status', ConceptStatus::Mastered->value)
                ->whereHas('domain', fn ($query) => $query->where('user_id', $userId))->count(),
            'in_progress' => Concept::query()->where('status', ConceptStatus::InProgress->value)
                ->whereHas('domain', fn ($query) => $query->where('user_id', $userId))->count(),
            'to_review' => Concept::query()->where('status', ConceptStatus::ToReview->value)
                ->whereHas('domain', fn ($query) => $query->where('user_id', $userId))->count(),
        ];

        $totalConcepts = array_sum($statusCounts);

        return view('progress.index', compact('domains', 'statusCounts', 'totalConcepts'));
    }
}
