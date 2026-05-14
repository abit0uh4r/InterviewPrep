<x-guest-layout>
    <div class="surface p-7 sm:p-9">
        <div class="mb-7 flex items-center gap-4">
            <x-application-logo class="h-14 w-14 shrink-0" />
            <div>
                <p class="text-2xl font-extrabold tracking-tight text-slate-950">InterviewPrep</p>
                <p class="text-2xl font-extrabold tracking-tight text-indigo-600">Laravel</p>
            </div>
        </div>

        <div class="mb-7 space-y-2">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-950">Connexion</h1>
            <p class="max-w-xl text-base leading-7 text-slate-500">Connectez-vous a votre compte pour continuer votre preparation aux entretiens.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Adresse e-mail')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="email" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="password" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between gap-4 text-sm">
                <label for="remember_me" class="inline-flex items-center gap-3 text-slate-500">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span>Se souvenir de moi</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                        Mot de passe oublie ?
                    </a>
                @endif
            </div>

            <button class="brand-button h-14 w-full text-base" type="submit">
                Se connecter
            </button>

            <div class="relative py-2 text-center text-sm text-slate-400">
                <span class="relative z-10 bg-white px-4">ou</span>
                <span class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-slate-200"></span>
            </div>

            <p class="text-center text-sm text-slate-500">
                Pas encore de compte ?
                <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}">
                    S'inscrire
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
