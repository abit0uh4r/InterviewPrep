<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-500">{{ $domain->name }}</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-950">Nouveau concept</h1>
        </div>
    </x-slot>

    <div class="content-wrap space-y-6">
        <div class="form-shell">
            <div class="form-panel">
                <aside class="form-aside">
                    <div>
                        <span class="inline-flex rounded-full bg-white/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-500 shadow-sm">
                            Révision
                        </span>
                        <h2 class="mt-5 text-3xl font-semibold leading-tight text-slate-950">Capture l’idée importante pendant qu’elle est encore fraîche.</h2>
                        <p class="mt-4 helper-text">
                            Un bon concept a un titre précis, une explication actionnable et un niveau de difficulté réaliste. C’est ce qui rend la suite utile.
                        </p>
                    </div>

                    <div class="mt-8 rounded-[24px] border border-white/70 bg-white/70 p-5 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">Raccourci mental</p>
                        <p class="mt-2 text-sm text-slate-600">
                            Si tu ne peux pas expliquer clairement le concept ici, la génération IA sera floue ensuite.
                        </p>
                    </div>
                </aside>

                <div class="form-main">
                    <form method="POST" action="{{ route('domains.concepts.store', $domain) }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="field-label" for="title">Titre</label>
                            <input id="title" name="title" value="{{ old('title') }}" class="field-input" placeholder="Ex: Eloquent N+1 problem" required>
                            @error('title') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="field-label" for="explanation">Explication</label>
                            <textarea id="explanation" name="explanation" rows="6" class="field-textarea" placeholder="Explique le concept, le problème, puis le bon réflexe à avoir." required>{{ old('explanation') }}</textarea>
                            @error('explanation') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="difficulty">Difficulté</label>
                                <select id="difficulty" name="difficulty" class="field-select">
                                    @foreach ($difficulties as $difficulty)
                                        <option value="{{ $difficulty->value }}" @selected(old('difficulty', 'junior') === $difficulty->value)>{{ $difficulty->label() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="field-label" for="status">Statut</label>
                                <select id="status" name="status" class="field-select">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}" @selected(old('status', 'to_review') === $status->value)>{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button class="brand-button" type="submit">Créer le concept</button>
                            <a href="{{ route('domains.concepts.index', $domain) }}" class="ghost-button">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
