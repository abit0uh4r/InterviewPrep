<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GroqQuestionGeneratorService
{
    public function generate(string $title, string $explanation): array
    {
        $apiKey = config('services.groq.key');
        $model = config('services.groq.model', 'llama-3.1-8b-instant');

        if (! $apiKey) {
            throw new RuntimeException('Groq API key is missing.');
        }

        $prompt = "Generate exactly 5 technical interview questions in JSON array format only.\n".
            "Concept title: {$title}\n".
            "Concept explanation: {$explanation}";

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert technical interviewer.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.5,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Groq API request failed.');
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new RuntimeException('Groq response is empty.');
        }

        $normalizedContent = trim($content);
        $normalizedContent = preg_replace('/^```(?:json)?\s*/i', '', $normalizedContent) ?? $normalizedContent;
        $normalizedContent = preg_replace('/\s*```$/', '', $normalizedContent) ?? $normalizedContent;
        $normalizedContent = trim($normalizedContent);

        $decoded = json_decode($normalizedContent, true);
        $questions = $this->extractQuestions($decoded);

        if ($questions === []) {
            preg_match_all('/^\s*[-\d\.\)]\s*(.+)$/m', $normalizedContent, $matches);
            $questions = $matches[1] ?? [];
        }

        $questions = array_values(array_filter(array_map(
            fn ($question) => trim((string) $question),
            $questions
        ), fn ($question) => $question !== ''));

        if (count($questions) < 5) {
            throw new RuntimeException('Groq did not return 5 valid questions.');
        }

        return array_slice($questions, 0, 5);
    }

    private function extractQuestions(mixed $decoded): array
    {
        if (! is_array($decoded)) {
            return [];
        }

        if (isset($decoded['questions']) && is_array($decoded['questions'])) {
            return $this->extractQuestions($decoded['questions']);
        }

        $questions = [];

        foreach ($decoded as $item) {
            if (is_string($item)) {
                $questions[] = $item;
                continue;
            }

            if (is_array($item)) {
                foreach (['question', 'text', 'content'] as $key) {
                    if (isset($item[$key]) && is_string($item[$key])) {
                        $questions[] = $item[$key];
                        continue 2;
                    }
                }
            }
        }

        return $questions;
    }
}
