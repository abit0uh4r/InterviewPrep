<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-950">Concepts</h1>
            <p class="mt-2 text-base text-slate-500">{{ $domain->name }} - gerer vos concepts, vos statuts et vos priorites de revision.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('domains.index') }}" class="hover:text-indigo-600">Domaines</a>
            <span>/</span>
            <span class="font-medium text-indigo-600">{{ $domain->name }}</span>
            <span>/</span>
            <span>Concepts</span>
        </div>

        <div class="surface p-5">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <form method="GET" class="grid gap-3 md:grid-cols-[220px_220px_auto]">
                    <select name="status" class="h-14 rounded-2xl border-slate-200 bg-white px-4 text-sm text-slate-700 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous les statuts</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected($statusFilter === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <select name="difficulty" class="h-14 rounded-2xl border-slate-200 bg-white px-4 text-sm text-slate-700 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous les niveaux</option>
                        @foreach ($difficulties as $difficulty)
                            <option value="{{ $difficulty->value }}" @selected($difficultyFilter === $difficulty->value)>{{ $difficulty->label() }}</option>
                        @endforeach
                    </select>
                    <button class="ghost-button h-14" type="submit">Filtrer</button>
                </form>

                <a href="{{ route('domains.concepts.create', $domain) }}" class="brand-button">
                    Nouveau concept
                </a>
            </div>
        </div>

        <div class="surface overflow-hidden">
            <div class="hidden grid-cols-[minmax(0,2fr)_140px_160px_140px_150px] gap-4 border-b border-slate-200/80 px-6 py-4 text-sm font-semibold text-slate-500 lg:grid">
                <span>Concept</span>
                <span>Niveau</span>
                <span>Statut</span>
                <span>Questions</span>
                <span>Actions</span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($concepts as $concept)
                    <div class="grid gap-4 px-6 py-5 lg:grid-cols-[minmax(0,2fr)_140px_160px_140px_150px] lg:items-center">
                        <div class="min-w-0">
                            <a href="{{ route('domains.concepts.show', [$domain, $concept]) }}" class="text-lg font-semibold text-slate-900 hover:text-indigo-600">
                                {{ $concept->title }}
                            </a>
                            <p class="mt-1 text-sm text-slate-500">{{ $domain->name }}</p>
                        </div>

                        <div>
                            <span class="difficulty-chip {{ $concept->difficulty->value === 'junior' ? 'difficulty-chip-junior' : ($concept->difficulty->value === 'mid' ? 'difficulty-chip-mid' : 'difficulty-chip-senior') }}">
                                {{ $concept->difficulty_label }}
                            </span>
                        </div>

                        <div>
                            <form method="POST" action="{{ route('concepts.status.update', $concept) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="h-11 rounded-2xl border-slate-200 bg-white px-3 text-sm font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}" @selected($concept->status->value === $status->value)>{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="text-sm font-semibold text-slate-500">
                            {{ $concept->generated_questions_count ?? $concept->generatedQuestions()->count() }}
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 transition hover:border-slate-300 hover:text-slate-900">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.5 3.5 4 4L9 19l-5 1 1-5 11.5-11.5Z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-red-100 bg-red-50 text-red-500 transition hover:border-red-200 hover:text-red-600" type="submit" onclick="return confirm('Archive this concept?');">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5h16" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 7.5 7.5 18a2 2 0 0 0 2 1.8h5a2 2 0 0 0 2-1.8l1-10.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5V5.8A1.8 1.8 0 0 1 10.8 4h2.4A1.8 1.8 0 0 1 15 5.8v1.7" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-8 text-sm text-slate-500">Aucun concept pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
