<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateConceptStatusRequest;
use App\Models\Concept;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ConceptStatusController extends Controller
{
    public function __invoke(UpdateConceptStatusRequest $request, Concept $concept): RedirectResponse
    {
        abort_if($concept->domain->user_id !== Auth::id(), 403);

        $concept->update($request->validated());

        return back()->with('success', 'Concept status updated.');
    }
}
