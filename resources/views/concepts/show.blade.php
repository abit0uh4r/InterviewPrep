<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">{{ $domain->name }}</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">{{ $concept->title }}</h1>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        @if (session('success'))
            <div class="surface border-emerald-200/70 bg-emerald-50/80 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="surface border-rose-200/70 bg-rose-50/80 px-4 py-3 text-sm font-medium text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="surface p-6 sm:p-7">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="difficulty-chip difficulty-chip-{{ $concept->difficulty->value }}">{{ $concept->difficulty_label }}</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-slate-600">
                        {{ $concept->status_label }}
                    </span>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-slate-950">Explication</h2>
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $concept->explanation }}</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}" class="ghost-button">Modifier la fiche</a>
                    <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ghost-button text-rose-600 hover:text-rose-700">Archiver</button>
                    </form>
                </div>
            </div>

            <div class="surface p-6 sm:p-7">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-indigo-500">IA</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-950">Questions d’entretien</h2>
                    </div>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                        {{ $concept->generatedQuestions->count() }} génération(s)
                    </span>
                </div>

                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Lance une génération quand la fiche est assez claire. L’historique reste attaché à ce concept pour comparer plusieurs formulations.
                </p>

                <form method="POST" action="{{ route('concepts.generated-questions.store', $concept) }}" class="mt-6">
                    @csrf
                    <button class="brand-button w-full" type="submit">
                        Generate Interview Questions
                    </button>
                </form>
            </div>
        </section>

        <section class="surface p-6 sm:p-7">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-indigo-500">Historique</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-950">Generation History</h2>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($concept->generatedQuestions as $generation)
                    <article class="rounded-[24px] border border-slate-200/80 bg-slate-50/70 p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm font-medium text-slate-500">{{ $generation->created_at->format('d/m/Y H:i') }}</p>
                            <form method="POST" action="{{ route('generated-questions.destroy', $generation) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm font-medium text-rose-600 transition hover:text-rose-700" type="submit">Delete</button>
                            </form>
                        </div>

                        <ol class="mt-4 space-y-3 pl-5 text-sm leading-7 text-slate-600">
                            @foreach ($generation->questions as $question)
                                <li class="list-decimal">{{ $question }}</li>
                            @endforeach
                        </ol>
                    </article>
                @empty
                    <div class="rounded-[24px] border border-dashed border-slate-200 bg-slate-50/70 px-5 py-10 text-center text-sm text-slate-500">
                        No AI generation yet.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
