<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">IA</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Historique des questions générées</h1>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="surface overflow-hidden">
            <div class="border-b border-slate-200/70 px-6 py-5 sm:px-7">
                <p class="text-sm text-slate-500">Toutes les générations sauvegardées, regroupées par concept.</p>
            </div>

            <div class="divide-y divide-slate-200/70">
                @forelse ($generations as $generation)
                    <article class="px-6 py-5 sm:px-7">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                            <div>
                                <a href="{{ route('domains.concepts.show', [$generation->concept->domain, $generation->concept]) }}" class="text-lg font-semibold text-slate-950 hover:text-indigo-600">
                                    {{ $generation->concept->title }}
                                </a>
                                <p class="mt-1 text-sm font-medium text-indigo-600">{{ $generation->concept->domain->name }}</p>
                                <p class="mt-2 text-xs text-slate-500">{{ $generation->created_at->format('d/m/Y H:i') }} · {{ $generation->provider }} · {{ $generation->model }}</p>

                                <ol class="mt-4 space-y-2 pl-5 text-sm leading-7 text-slate-600">
                                    @foreach ($generation->questions as $question)
                                        <li class="list-decimal">{{ $question }}</li>
                                    @endforeach
                                </ol>
                            </div>

                            <form method="POST" action="{{ route('generated-questions.destroy', $generation) }}">
                                @csrf
                                @method('DELETE')
                                <button class="ghost-button text-rose-600 hover:text-rose-700" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-14 text-center text-sm text-slate-500 sm:px-7">
                        Aucune génération IA enregistrée pour le moment.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
