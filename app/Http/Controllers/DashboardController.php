<?php

namespace App\Http\Controllers;

use App\Enums\ConceptStatus;
use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $userId = Auth::id();

        $domainsCount = Domain::where('user_id', $userId)->count();
        $conceptsCount = Concept::whereHas('domain', fn ($q) => $q->where('user_id', $userId))->count();

        $statusCounts = [
            ConceptStatus::ToReview->value => Concept::where('status', ConceptStatus::ToReview->value)
                ->whereHas('domain', fn ($q) => $q->where('user_id', $userId))->count(),
            ConceptStatus::InProgress->value => Concept::where('status', ConceptStatus::InProgress->value)
                ->whereHas('domain', fn ($q) => $q->where('user_id', $userId))->count(),
            ConceptStatus::Mastered->value => Concept::where('status', ConceptStatus::Mastered->value)
                ->whereHas('domain', fn ($q) => $q->where('user_id', $userId))->count(),
        ];

        $domains = Domain::where('user_id', $userId)
            ->withCount([
                'concepts',
                'concepts as mastered_concepts_count' => fn ($q) => $q->where('status', ConceptStatus::Mastered->value),
                'concepts as to_review_concepts_count' => fn ($q) => $q->where('status', ConceptStatus::ToReview->value),
            ])->get();

        $bestDomain = $domains->sortByDesc('mastered_concepts_count')->first();
        $worstDomain = $domains->sortByDesc('to_review_concepts_count')->first();

        return view('dashboard', compact('domainsCount', 'conceptsCount', 'statusCounts', 'bestDomain', 'worstDomain'));
    }
}
