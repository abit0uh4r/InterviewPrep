<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-950">Domaines</h1>
            <p class="mt-1.5 text-sm text-slate-500">Organisez vos connaissances techniques par domaine et suivez votre progression.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 lg:grid-cols-3">
            <div class="metric-card">
                <p class="text-sm font-medium text-slate-500">Domaines totaux</p>
                <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $domains->count() }}</p>
            </div>
            <div class="metric-card">
                <p class="text-sm font-medium text-slate-500">Concepts totaux</p>
                <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">{{ $domains->sum('concepts_count') }}</p>
            </div>
            <div class="metric-card flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Maitrise moyenne</p>
                    <p class="mt-2.5 text-4xl font-extrabold tracking-tight text-slate-950">
                        {{ $domains->sum('concepts_count') > 0 ? number_format(($domains->sum('mastered_concepts_count') / $domains->sum('concepts_count')) * 100, 1) : 0 }}%
                    </p>
                </div>
                <a href="{{ route('domains.create') }}" class="brand-button">Nouveau domaine</a>
            </div>
        </div>

            <div class="grid gap-5 xl:grid-cols-2 2xl:grid-cols-3">
            @forelse ($domains as $domain)
                @php
                    $progress = $domain->concepts_count > 0 ? round(($domain->mastered_concepts_count / $domain->concepts_count) * 100) : 0;
                @endphp
                <article class="surface overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <span class="flex h-14 w-14 items-center justify-center rounded-[22px] bg-violet-50">
                                    <span class="inline-block h-3.5 w-3.5 rounded-full" style="background-color: {{ $domain->color }}"></span>
                                </span>
                                <div>
                                    <a href="{{ route('domains.show', $domain) }}" class="text-xl font-bold tracking-tight text-slate-950 hover:text-indigo-600">
                                        {{ $domain->name }}
                                    </a>
                                    <p class="mt-1 text-sm text-slate-500">{{ $domain->concepts_count }} concepts</p>
                                </div>
                            </div>
                            <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Voir</a>
                        </div>

                        <div class="mt-6">
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-500">Progression</span>
                                <span class="font-bold text-slate-800">{{ $progress }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-px border-t border-slate-200/80 bg-slate-100/80 text-sm">
                        <a href="{{ route('domains.concepts.index', $domain) }}" class="flex items-center justify-center bg-white px-4 py-4 font-medium text-slate-600 transition hover:text-slate-900">
                            Concepts
                        </a>
                        <a href="{{ route('domains.edit', $domain) }}" class="flex items-center justify-center bg-white px-4 py-4 font-medium text-slate-600 transition hover:text-slate-900">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('domains.destroy', $domain) }}" class="bg-white">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex w-full items-center justify-center px-4 py-4 font-medium text-red-500 transition hover:text-red-600" onclick="return confirm('Delete this domain?');">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="surface p-8 xl:col-span-2 2xl:col-span-3">
                    <p class="text-base text-slate-500">Aucun domaine pour le moment. Cree ton premier domaine pour lancer ta preparation.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
