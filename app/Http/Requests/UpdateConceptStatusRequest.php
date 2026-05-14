<?php

namespace App\Http\Requests;

use App\Enums\ConceptStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateConceptStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(ConceptStatus::class)],
        ];
    }
}
