<?php

namespace App\Http\Controllers;

use App\Enums\ConceptDifficulty;
use App\Enums\ConceptStatus;
use App\Models\Concept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConceptLibraryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $status = $request->string('status')->toString();
        $difficulty = $request->string('difficulty')->toString();

        $concepts = Concept::query()
            ->with(['domain'])
            ->withCount('generatedQuestions')
            ->whereHas('domain', fn ($query) => $query->where('user_id', Auth::id()))
            ->when($search, fn ($query) => $query->where(function ($nested) use ($search): void {
                $nested->where('title', 'like', "%{$search}%")
                    ->orWhere('explanation', 'like', "%{$search}%")
                    ->orWhereHas('domain', fn ($domainQuery) => $domainQuery->where('name', 'like', "%{$search}%"));
            }))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($difficulty, fn ($query) => $query->where('difficulty', $difficulty))
            ->latest()
            ->get();

        return view('concepts.library', [
            'concepts' => $concepts,
            'search' => $search,
            'statusFilter' => $status,
            'difficultyFilter' => $difficulty,
            'statuses' => ConceptStatus::cases(),
            'difficulties' => ConceptDifficulty::cases(),
        ]);
    }
}
