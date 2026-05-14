<?php

namespace App\Providers;

use App\Enums\ConceptStatus;
use App\Models\Concept;
use App\Models\GeneratedQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view): void {
            if (! Auth::check()) {
                $view->with('topbarNotifications', [
                    'toReviewCount' => 0,
                    'archivedCount' => 0,
                    'recentGenerations' => collect(),
                ]);

                return;
            }

            $userId = Auth::id();

            $toReviewCount = Concept::query()
                ->where('status', ConceptStatus::ToReview->value)
                ->whereHas('domain', fn ($query) => $query->where('user_id', $userId))
                ->count();

            $archivedCount = Concept::onlyTrashed()
                ->whereHas('domain', fn ($query) => $query->where('user_id', $userId))
                ->count();

            $recentGenerations = GeneratedQuestion::query()
                ->with(['concept.domain'])
                ->whereHas('concept.domain', fn ($query) => $query->where('user_id', $userId))
                ->latest()
                ->take(3)
                ->get();

            $view->with('topbarNotifications', [
                'toReviewCount' => $toReviewCount,
                'archivedCount' => $archivedCount,
                'recentGenerations' => $recentGenerations,
            ]);
        });
    }
}
