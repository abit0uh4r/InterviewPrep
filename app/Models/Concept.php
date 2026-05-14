<?php

namespace App\Models;

use App\Enums\ConceptDifficulty;
use App\Enums\ConceptStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concept extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'domain_id',
        'title',
        'explanation',
        'difficulty',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => ConceptDifficulty::class,
            'status' => ConceptStatus::class,
        ];
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function generatedQuestions(): HasMany
    {
        return $this->hasMany(GeneratedQuestion::class);
    }

    protected function difficultyLabel(): Attribute
    {
        return Attribute::get(fn () => $this->difficulty?->label() ?? '');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => $this->status?->label() ?? '');
    }
}
