<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-950">Tableau de bord</h1>
            <p class="mt-1.5 text-sm text-slate-500">Visualisez votre progression globale et concentrez-vous sur les prochaines revisions utiles.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="metric-card">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Domaines</p>
                        <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $domainsCount }}</p>
                        <p class="mt-2 text-sm font-medium text-indigo-600">Vue globale</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-[22px] bg-violet-50 text-indigo-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="4" width="7" height="7" rx="1.5" />
                            <rect x="13" y="4" width="7" height="7" rx="1.5" />
                            <rect x="4" y="13" width="7" height="7" rx="1.5" />
                            <rect x="13" y="13" width="7" height="7" rx="1.5" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Concepts</p>
                        <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $conceptsCount }}</p>
                        <p class="mt-2 text-sm font-medium text-sky-600">Base de revision</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-[22px] bg-sky-50 text-sky-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 6.5A2.5 2.5 0 0 1 8 4h10.5v14H8a2.5 2.5 0 0 0-2.5 2.5V6.5Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 4H5.5v16" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Maitrises</p>
                        <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $statusCounts['mastered'] }}</p>
                        <p class="mt-2 text-sm font-medium text-emerald-600">
                            {{ $conceptsCount > 0 ? number_format(($statusCounts['mastered'] / $conceptsCount) * 100, 1) : 0 }}% du total
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-[22px] bg-emerald-50 text-emerald-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="8" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.2 2.2L15.8 9" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">A revoir</p>
                        <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $statusCounts['to_review'] }}</p>
                        <p class="mt-2 text-sm font-medium text-orange-600">
                            {{ $conceptsCount > 0 ? number_format(($statusCounts['to_review'] / $conceptsCount) * 100, 1) : 0 }}% du total
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-[22px] bg-orange-50 text-orange-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v4m0 8v4m8-8h-4M8 12H4" />
                            <circle cx="12" cy="12" r="7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="surface p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold tracking-tight text-slate-950">Progression par domaine</h2>
                    <a href="{{ route('domains.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Voir tout</a>
                </div>
                <div class="mt-5 space-y-5">
                    @forelse (\App\Models\Domain::where('user_id', auth()->id())->withCount(['concepts', 'concepts as mastered_concepts_count' => fn ($q) => $q->where('status', 'mastered')])->get() as $domain)
                        @php
                            $progress = $domain->concepts_count > 0 ? round(($domain->mastered_concepts_count / $domain->concepts_count) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-4">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-[20px] bg-violet-50">
                                <span class="inline-block h-3 w-3 rounded-full" style="background-color: {{ $domain->color }}"></span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="mb-2 flex items-center justify-between gap-4">
                                    <p class="truncate text-base font-semibold text-slate-900">{{ $domain->name }}</p>
                                    <span class="text-base font-bold text-slate-700">{{ $progress }}%</span>
                                </div>
                                <div class="h-3 rounded-full bg-slate-100">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Ajoutez vos premiers domaines pour voir la progression apparaitre ici.</p>
                    @endforelse
                </div>
                <a href="{{ route('domains.index') }}" class="ghost-button mt-8 w-full">Voir la progression detaillee</a>
            </div>

            <div class="space-y-6">
                <div class="surface p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold tracking-tight text-slate-950">Points de focus</h2>
                        <a href="{{ route('domains.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Voir tout</a>
                    </div>
                    <div class="mt-5 space-y-4">
                        @if ($bestDomain)
                            <div class="flex gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-[20px] bg-emerald-50 text-emerald-600">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="8" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.2 2.2L15.8 9" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base font-semibold text-slate-900">{{ $bestDomain->name }}</p>
                                    <p class="text-sm text-slate-500">Top maitrise</p>
                                    <p class="mt-1 text-sm font-medium text-emerald-600">{{ $bestDomain->mastered_concepts_count }} concepts maitrises</p>
                                </div>
                            </div>
                        @endif
                        @if ($worstDomain)
                            <div class="flex gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-[20px] bg-orange-50 text-orange-600">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v4m0 8v4m8-8h-4M8 12H4" />
                                        <circle cx="12" cy="12" r="7.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base font-semibold text-slate-900">{{ $worstDomain->name }}</p>
                                    <p class="text-sm text-slate-500">Le plus a revoir</p>
                                    <p class="mt-1 text-sm font-medium text-orange-600">{{ $worstDomain->to_review_concepts_count }} concepts en attente</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="surface p-5">
                    <h2 class="text-xl font-bold tracking-tight text-slate-950">Repartition par statut</h2>
                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
                                <span class="font-medium text-slate-700">Maitrises</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $statusCounts['mastered'] }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-3 w-3 rounded-full bg-sky-500"></span>
                                <span class="font-medium text-slate-700">En cours</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $statusCounts['in_progress'] }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-3 w-3 rounded-full bg-orange-500"></span>
                                <span class="font-medium text-slate-700">A revoir</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $statusCounts['to_review'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
