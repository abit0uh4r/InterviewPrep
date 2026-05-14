<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\GeneratedQuestion;
use App\Services\GroqQuestionGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeneratedQuestionController extends Controller
{
    public function store(Concept $concept, GroqQuestionGeneratorService $service): RedirectResponse
    {
        abort_if($concept->domain->user_id !== Auth::id(), 403);

        try {
            $questions = $service->generate($concept->title, $concept->explanation);

            $concept->generatedQuestions()->create([
                'questions' => $questions,
                'provider' => 'groq',
                'model' => config('services.groq.model'),
            ]);
        } catch (Throwable $e) {
            Log::error('Groq generation failed', [
                'concept_id' => $concept->id,
                'error' => $e->getMessage(),
            ]);

            $message = app()->isLocal()
                ? 'Unable to generate questions right now. ' . $e->getMessage()
                : 'Unable to generate questions right now.';

            return back()->with('error', $message);
        }

        return back()->with('success', 'Interview questions generated successfully.');
    }

    public function destroy(GeneratedQuestion $generatedQuestion): RedirectResponse
    {
        abort_if($generatedQuestion->concept->domain->user_id !== Auth::id(), 403);
        $generatedQuestion->delete();

        return back()->with('success', 'Generated question set deleted.');
    }
}
