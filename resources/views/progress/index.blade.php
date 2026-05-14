<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Progression</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Vue détaillée de l’avancement</h1>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="metric-card">
                <p class="text-sm text-slate-500">Maitrisés</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $statusCounts['mastered'] }}</p>
                <p class="mt-2 text-sm text-emerald-600">{{ $totalConcepts > 0 ? number_format(($statusCounts['mastered'] / $totalConcepts) * 100, 1) : 0 }}% du total</p>
            </div>
            <div class="metric-card">
                <p class="text-sm text-slate-500">En cours</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $statusCounts['in_progress'] }}</p>
                <p class="mt-2 text-sm text-sky-600">{{ $totalConcepts > 0 ? number_format(($statusCounts['in_progress'] / $totalConcepts) * 100, 1) : 0 }}% du total</p>
            </div>
            <div class="metric-card">
                <p class="text-sm text-slate-500">À revoir</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $statusCounts['to_review'] }}</p>
                <p class="mt-2 text-sm text-orange-600">{{ $totalConcepts > 0 ? number_format(($statusCounts['to_review'] / $totalConcepts) * 100, 1) : 0 }}% du total</p>
            </div>
        </div>

        <section class="surface overflow-hidden">
            <div class="border-b border-slate-200/70 px-6 py-5 sm:px-7">
                <p class="text-sm text-slate-500">Détail par domaine avec répartition des statuts.</p>
            </div>

            <div class="divide-y divide-slate-200/70">
                @forelse ($domains as $domain)
                    @php
                        $progress = $domain->concepts_count > 0 ? round(($domain->mastered_concepts_count / $domain->concepts_count) * 100) : 0;
                    @endphp

                    <div class="px-6 py-5 sm:px-7">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="h-4 w-4 rounded-full" style="background-color: {{ $domain->color }}"></span>
                                    <a href="{{ route('domains.concepts.index', $domain) }}" class="text-lg font-semibold text-slate-950 hover:text-indigo-600">{{ $domain->name }}</a>
                                </div>

                                <div class="mt-4 h-3 rounded-full bg-slate-100">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-4 xl:min-w-[460px]">
                                <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                    <p class="text-slate-500">Total</p>
                                    <p class="mt-1 font-bold text-slate-950">{{ $domain->concepts_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm">
                                    <p class="text-emerald-700">Maitrise</p>
                                    <p class="mt-1 font-bold text-emerald-900">{{ $domain->mastered_concepts_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-sky-50 px-4 py-3 text-sm">
                                    <p class="text-sky-700">En cours</p>
                                    <p class="mt-1 font-bold text-sky-900">{{ $domain->in_progress_concepts_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-orange-50 px-4 py-3 text-sm">
                                    <p class="text-orange-700">À revoir</p>
                                    <p class="mt-1 font-bold text-orange-900">{{ $domain->to_review_concepts_count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-14 text-center text-sm text-slate-500 sm:px-7">
                        Ajoute des domaines et des concepts pour voir une progression détaillée.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
