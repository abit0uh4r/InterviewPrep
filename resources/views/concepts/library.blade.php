<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Bibliothèque</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Tous les concepts</h1>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="surface p-5 sm:p-6">
            <form method="GET" action="{{ route('concepts.index') }}" class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr_0.7fr_auto]">
                <input
                    type="text"
                    name="q"
                    value="{{ $search }}"
                    class="field-input"
                    placeholder="Rechercher un titre, une explication, un domaine..."
                >

                <select name="status" class="field-select">
                    <option value="">Tous les statuts</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected($statusFilter === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>

                <select name="difficulty" class="field-select">
                    <option value="">Toutes les difficultés</option>
                    @foreach ($difficulties as $difficulty)
                        <option value="{{ $difficulty->value }}" @selected($difficultyFilter === $difficulty->value)>{{ $difficulty->label() }}</option>
                    @endforeach
                </select>

                <button class="brand-button" type="submit">Filtrer</button>
            </form>
        </section>

        <section class="surface overflow-hidden">
            <div class="border-b border-slate-200/70 px-6 py-5 sm:px-7">
                <p class="text-sm text-slate-500">{{ $concepts->count() }} concept(s) trouvé(s)</p>
            </div>

            <div class="divide-y divide-slate-200/70">
                @forelse ($concepts as $concept)
                    <div class="px-6 py-5 sm:px-7">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('domains.concepts.show', [$concept->domain, $concept]) }}" class="text-lg font-semibold text-slate-950 hover:text-indigo-600">
                                        {{ $concept->title }}
                                    </a>
                                    <span class="difficulty-chip difficulty-chip-{{ $concept->difficulty->value }}">{{ $concept->difficulty_label }}</span>
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $concept->status_label }}</span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600">{{ $concept->domain->name }}</p>
                                <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600">{{ \Illuminate\Support\Str::limit($concept->explanation, 220) }}</p>
                            </div>

                            <div class="flex shrink-0 items-center gap-3 text-sm text-slate-500">
                                <span>{{ $concept->generated_questions_count }} génération(s)</span>
                                <a href="{{ route('domains.concepts.edit', [$concept->domain, $concept]) }}" class="ghost-button">Modifier</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-14 text-center text-sm text-slate-500 sm:px-7">
                        Aucun concept ne correspond à cette recherche.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
