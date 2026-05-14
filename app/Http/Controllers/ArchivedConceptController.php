<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArchivedConceptController extends Controller
{
    public function index(): View
    {
        $concepts = Concept::onlyTrashed()
            ->with('domain')
            ->whereHas('domain', fn ($q) => $q->where('user_id', Auth::id()))
            ->latest('deleted_at')
            ->get();

        return view('concepts.archived', compact('concepts'));
    }

    public function restore(int $concept): RedirectResponse
    {
        $archived = Concept::onlyTrashed()->findOrFail($concept);
        abort_if($archived->domain->user_id !== Auth::id(), 403);
        $archived->restore();

        return back()->with('success', 'Concept restored successfully.');
    }
}
