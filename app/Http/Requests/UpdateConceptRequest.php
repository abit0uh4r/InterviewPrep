<?php

namespace App\Http\Requests;

use App\Enums\ConceptDifficulty;
use App\Enums\ConceptStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'explanation' => ['required', 'string'],
            'difficulty' => ['required', new Enum(ConceptDifficulty::class)],
            'status' => ['required', new Enum(ConceptStatus::class)],
        ];
    }
}
