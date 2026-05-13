<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $domains = Domain::query()->where('user_id', Auth::id())->latest()->get();
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
        ...$request->validated()
        ]);
        return redirect()->route('domains.index')->with('success', 'Domain created successfully.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
    
        //
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
