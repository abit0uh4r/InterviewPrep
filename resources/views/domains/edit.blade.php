<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">Domaines</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Modifier {{ $domain->name }}</h1>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        <div class="form-shell">
            <div class="form-panel">
                <aside class="form-aside">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="h-4 w-4 rounded-full shadow-sm" style="background-color: {{ $domain->color }}"></span>
                            <span class="text-sm font-semibold text-slate-700">Domaine actuel</span>
                        </div>
                        <h2 class="mt-4 text-[1.8rem] font-semibold leading-tight text-slate-950">{{ $domain->name }}</h2>
                        <p class="mt-4 helper-text">
                            Ajuste le nom ou la couleur pour garder une bibliotheque claire et facile a parcourir au quotidien.
                        </p>
                    </div>

                    <div class="mt-8 rounded-[24px] border border-white/70 bg-white/70 p-5 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">Conseil</p>
                        <p class="mt-2 text-sm text-slate-600">
                            Choisis des noms courts et specifiques. C'est ce qui rend la navigation plus rapide quand les concepts deviennent nombreux.
                        </p>
                    </div>
                </aside>

                <div class="form-main">
                    <form method="POST" action="{{ route('domains.update', $domain) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="field-label">Nom du domaine</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $domain->name) }}"
                                class="field-input"
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
                                    value="{{ old('color', $domain->color) }}"
                                    class="field-color"
                                    required
                                >
                                <p class="helper-text">La couleur aide a reperer visuellement ce domaine sur le dashboard et dans les listes.</p>
                            </div>
                            @error('color')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button type="submit" class="brand-button">Enregistrer</button>
                            <a href="{{ route('domains.index') }}" class="ghost-button">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
