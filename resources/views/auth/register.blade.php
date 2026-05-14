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
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-950">Creer un compte</h1>
            <p class="max-w-xl text-base leading-7 text-slate-500">Rejoignez InterviewPrep Laravel et commencez votre preparation des aujourd'hui.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Nom')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="name" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="email" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="password" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="mb-2 block text-sm font-semibold text-slate-800" />
                <x-text-input id="password_confirmation" class="block h-14 w-full rounded-2xl border-slate-200 bg-white px-4 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button class="brand-button mt-2 h-14 w-full text-base" type="submit">
                Creer mon compte
            </button>

            <div class="relative py-2 text-center text-sm text-slate-400">
                <span class="relative z-10 bg-white px-4">ou</span>
                <span class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-slate-200"></span>
            </div>

            <p class="text-center text-sm text-slate-500">
                Deja un compte ?
                <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                    Se connecter
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
