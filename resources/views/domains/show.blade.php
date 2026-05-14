<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <span class="h-5 w-5 rounded-full shadow-sm" style="background-color: {{ $domain->color }}"></span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Domaine</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-950">{{ $domain->name }}</h1>
            </div>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        <section class="surface p-6 sm:p-7">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-600">
                        Vue d’ensemble
                    </span>
                    <h2 class="mt-4 text-3xl font-semibold text-slate-950">{{ $domain->name }}</h2>
                    <p class="mt-3 text-sm leading-7 text-slate-600">
                        Utilise cette entrée comme point d’accès à tous les concepts liés, à leur progression, puis à la génération de questions ciblées.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('domains.concepts.index', $domain) }}" class="brand-button">Voir les concepts</a>
                    <a href="{{ route('domains.edit', $domain) }}" class="ghost-button">Modifier</a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
