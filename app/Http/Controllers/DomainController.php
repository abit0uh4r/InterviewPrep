<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $domains = Domain::query()
            ->where('user_id', Auth::id())
            ->withCount([
                'concepts',
                'concepts as mastered_concepts_count' => fn ($query) => $query->where('status', 'mastered'),
            ])
            ->latest()
            ->get();

        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDomainRequest $request): RedirectResponse
    {
        Domain::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
        ]);

        return redirect()->route('domains.index')->with('success', 'Domain created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Domain $domain): View
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        return view('domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain): View
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        return view('domains.edit', compact('domain'));
    }

        
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDomainRequest $request, Domain $domain): RedirectResponse
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        $domain->update($request->validated());

        return redirect()->route('domains.index')->with('success', 'Domain updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain): RedirectResponse
    {
        abort_if($domain->user_id !== Auth::id(), 403);

        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domain deleted successfully.');
    }
}
