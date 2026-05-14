<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Domaines</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Nouveau domaine</h1>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        <div class="form-shell">
            <div class="form-panel">
                <aside class="form-aside">
                    <div>
                        <span class="inline-flex rounded-full bg-white/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-500 shadow-sm">
                            Structure
                        </span>
                        <h2 class="mt-4 text-[1.8rem] font-semibold leading-tight text-slate-950">Cree une categorie claire pour organiser tes revisions.</h2>
                        <p class="mt-4 helper-text">
                            Chaque domaine regroupe des concepts proches, ce qui rend le suivi de progression et la generation de questions beaucoup plus lisibles.
                        </p>
                    </div>

                    <div class="mt-8 rounded-[24px] border border-white/70 bg-white/70 p-5 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">Exemples utiles</p>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600">
                            <li>Laravel ORM</li>
                            <li>System Design</li>
                            <li>Architecture PHP</li>
                        </ul>
                    </div>
                </aside>

                <div class="form-main">
                    <form method="POST" action="{{ route('domains.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="field-label">Nom du domaine</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                class="field-input"
                                placeholder="Ex: Laravel ORM"
                                required
                            >
                            @error('name')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="field-label">Couleur repere</label>
                            <div class="flex items-center gap-4">
                                <input
                                    id="color"
                                    name="color"
                                    type="color"
                                    value="{{ old('color', '#5b5cf0') }}"
                                    class="field-color"
                                    required
                                >
                                <p class="helper-text">Cette couleur sera utilisee dans les cartes, les badges et les indicateurs de progression.</p>
                            </div>
                            @error('color')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button type="submit" class="brand-button">Creer le domaine</button>
                            <a href="{{ route('domains.index') }}" class="ghost-button">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
