@php
    $activeDomain = request()->route('domain');
@endphp

<aside class="app-sidebar px-6 py-7">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <x-application-logo class="h-14 w-14 shrink-0" />
        <div>
            <p class="text-2xl font-extrabold tracking-tight text-slate-950">InterviewPrep</p>
            <p class="text-2xl font-extrabold tracking-tight text-indigo-600">Laravel</p>
        </div>
    </a>

    <div class="mt-7 border-t border-slate-200/80 pt-7">
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 12 4l9 7.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 10.5V20h13V10.5" />
                </svg>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('domains.index') }}" class="sidebar-link {{ request()->routeIs('domains.*') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <rect x="4" y="4" width="7" height="7" rx="1.5" />
                    <rect x="13" y="4" width="7" height="7" rx="1.5" />
                    <rect x="4" y="13" width="7" height="7" rx="1.5" />
                    <rect x="13" y="13" width="7" height="7" rx="1.5" />
                </svg>
                <span>Domaines</span>
            </a>
            <a href="{{ route('concepts.index') }}" class="sidebar-link {{ request()->routeIs('concepts.index', 'domains.concepts.*') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4.5h10a1.5 1.5 0 0 1 1.5 1.5v12A1.5 1.5 0 0 1 17 19.5H7A1.5 1.5 0 0 1 5.5 18V6A1.5 1.5 0 0 1 7 4.5Z" />
                    <path stroke-linecap="round" d="M9 8.5h6M9 12h6M9 15.5h4" />
                </svg>
                <span>Concepts</span>
            </a>
            <a href="{{ route('archived-concepts.index') }}" class="sidebar-link {{ request()->routeIs('archived-concepts.*') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5h16" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 7.5 7.5 18a2 2 0 0 0 2 1.8h5a2 2 0 0 0 2-1.8l1-10.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5V5.8A1.8 1.8 0 0 1 10.8 4h2.4A1.8 1.8 0 0 1 15 5.8v1.7" />
                </svg>
                <span>Archives</span>
            </a>
            <a href="{{ route('generated-questions.index') }}" class="sidebar-link {{ request()->routeIs('generated-questions.*') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 6.5 5 12l3.5 5.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 6.5 19 12l-3.5 5.5" />
                    <path stroke-linecap="round" d="m13 5-2 14" />
                </svg>
                <span>Questions IA</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <circle cx="12" cy="12" r="3.2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1 1 0 0 0 .2 1.1l.1.1a1.8 1.8 0 0 1-1.3 3.1h-.2a1 1 0 0 0-.9.6l-.1.2a1.8 1.8 0 0 1-3.1 0l-.1-.2a1 1 0 0 0-.9-.6h-.2a1.8 1.8 0 0 1-1.3-3.1l.1-.1a1 1 0 0 0 .2-1.1 1 1 0 0 0-.9-.6H7.8a1.8 1.8 0 0 1 0-3.6h.2a1 1 0 0 0 .9-.6 1 1 0 0 0-.2-1.1l-.1-.1a1.8 1.8 0 0 1 1.3-3.1h.2a1 1 0 0 0 .9-.6l.1-.2a1.8 1.8 0 0 1 3.1 0l.1.2a1 1 0 0 0 .9.6h.2a1.8 1.8 0 0 1 1.3 3.1l-.1.1a1 1 0 0 0-.2 1.1 1 1 0 0 0 .9.6h.2a1.8 1.8 0 0 1 0 3.6h-.2a1 1 0 0 0-.9.6Z" />
                </svg>
                <span>Parametres</span>
            </a>
        </nav>
    </div>

    <div class="mt-auto">
        <div class="surface overflow-hidden p-5">
            <div class="rounded-[24px] bg-gradient-to-br from-indigo-50 via-violet-50 to-white p-4">
                <div class="mx-auto flex h-36 w-36 items-end justify-center rounded-full bg-gradient-to-br from-violet-100 to-indigo-50">
                    <div class="relative mb-4 h-24 w-16">
                        <div class="absolute inset-x-2 top-0 h-14 rounded-t-full rounded-b-[40%] bg-white shadow-[0_12px_40px_rgba(99,102,241,0.15)]"></div>
                        <div class="absolute left-1/2 top-7 h-5 w-5 -translate-x-1/2 rounded-full bg-violet-300 ring-4 ring-indigo-50"></div>
                        <div class="absolute left-0 top-8 h-8 w-4 -translate-x-1 rotate-[18deg] rounded-l-full rounded-r-sm bg-indigo-500"></div>
                        <div class="absolute right-0 top-8 h-8 w-4 translate-x-1 -rotate-[18deg] rounded-r-full rounded-l-sm bg-indigo-500"></div>
                        <div class="absolute bottom-0 left-1/2 h-10 w-3 -translate-x-1/2 rounded-b-full bg-indigo-500"></div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <h3 class="text-2xl font-bold tracking-tight text-slate-950">Pret a decoller !</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">Continuez votre apprentissage chaque jour et atteignez vos objectifs.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="brand-button mt-5 w-full">Voir ma progression</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-5">
            @csrf
            <button class="sidebar-link w-full" type="submit">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h7a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-7" />
                </svg>
                <span>Deconnexion</span>
            </button>
        </form>
    </div>
</aside>
