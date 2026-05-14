<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Archives</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Concepts archivés</h1>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        @if (session('success'))
            <div class="surface border-emerald-200/70 bg-emerald-50/80 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <section class="surface overflow-hidden">
            <div class="border-b border-slate-200/70 px-6 py-5 sm:px-7">
                <p class="text-sm text-slate-500">Retrouve ici les concepts retirés de la bibliothèque active et restaure-les quand ils redeviennent pertinents.</p>
            </div>

            <div class="divide-y divide-slate-200/70">
                @forelse ($concepts as $concept)
                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <p class="text-base font-semibold text-slate-950">{{ $concept->title }}</p>
                                <span class="difficulty-chip difficulty-chip-{{ $concept->difficulty->value }}">{{ $concept->difficulty_label }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">{{ $concept->domain->name }} · archivé {{ $concept->deleted_at?->diffForHumans() }}</p>
                        </div>

                        <form method="POST" action="{{ route('archived-concepts.restore', $concept->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="brand-button" type="submit">Restaurer</button>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-slate-500 sm:px-7">
                        Aucun concept archivé pour le moment.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
