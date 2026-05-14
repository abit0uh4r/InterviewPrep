<?php

namespace App\Http\Controllers;

use App\Enums\ConceptDifficulty;
use App\Enums\ConceptStatus;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConceptController extends Controller
{
    public function index(Request $request, Domain $domain): View
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        $status = $request->string('status')->toString();
        $difficulty = $request->string('difficulty')->toString();

        $concepts = $domain->concepts()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($difficulty, fn ($q) => $q->where('difficulty', $difficulty))
            ->latest()
            ->get();

        return view('concepts.index', [
            'domain' => $domain,
            'concepts' => $concepts,
            'statusFilter' => $status,
            'difficultyFilter' => $difficulty,
            'statuses' => ConceptStatus::cases(),
            'difficulties' => ConceptDifficulty::cases(),
        ]);
    }

    public function create(Domain $domain): View
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        return view('concepts.create', [
            'domain' => $domain,
            'statuses' => ConceptStatus::cases(),
            'difficulties' => ConceptDifficulty::cases(),
        ]);
    }

    public function store(StoreConceptRequest $request, Domain $domain): RedirectResponse
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        $domain->concepts()->create([
            ...$request->validated(),
            'status' => $request->validated('status') ?? ConceptStatus::ToReview->value,
        ]);

        return redirect()
            ->route('domains.concepts.index', $domain)
            ->with('success', 'Concept created successfully.');
    }

    public function show(Domain $domain, Concept $concept): View
    {
        abort_if($domain->user_id !== Auth::id() || $concept->domain_id !== $domain->id, 403);

        $concept->load('generatedQuestions');

        return view('concepts.show', compact('domain', 'concept'));
    }

    public function edit(Domain $domain, Concept $concept): View
    {
        abort_if($domain->user_id !== Auth::id() || $concept->domain_id !== $domain->id, 403);

        return view('concepts.edit', [
            'domain' => $domain,
            'concept' => $concept,
            'statuses' => ConceptStatus::cases(),
            'difficulties' => ConceptDifficulty::cases(),
        ]);
    }

    public function update(UpdateConceptRequest $request, Domain $domain, Concept $concept): RedirectResponse
    {
        abort_if($domain->user_id !== Auth::id() || $concept->domain_id !== $domain->id, 403);

        $concept->update($request->validated());

        return redirect()
            ->route('domains.concepts.index', $domain)
            ->with('success', 'Concept updated successfully.');
    }

    public function destroy(Domain $domain, Concept $concept): RedirectResponse
    {
        abort_if($domain->user_id !== Auth::id() || $concept->domain_id !== $domain->id, 403);

        $concept->delete();

        return redirect()
            ->route('domains.concepts.index', $domain)
            ->with('success', 'Concept archived successfully.');
    }
}
