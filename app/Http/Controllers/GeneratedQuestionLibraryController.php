<?php

namespace App\Http\Controllers;

use App\Models\GeneratedQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GeneratedQuestionLibraryController extends Controller
{
    public function __invoke(): View
    {
        $generations = GeneratedQuestion::query()
            ->with(['concept.domain'])
            ->whereHas('concept.domain', fn ($query) => $query->where('user_id', Auth::id()))
            ->latest()
            ->get();

        return view('generated-questions.index', compact('generations'));
    }
}
