<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">
    <div class="app-shell">
        @include('layouts.navigation')

        <div class="app-main">
            <header class="app-topbar">
                <div class="min-w-0">
                    @isset($header)
                        {{ $header }}
                    @else
                        <h1 class="text-2xl font-bold tracking-tight text-slate-950">InterviewPrep</h1>
                    @endisset
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('concepts.index') }}" method="GET" class="hidden min-[1100px]:block">
                        <label class="flex min-w-[400px] items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-400">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="M20 20l-3.5-3.5" />
                            </svg>
                            <input class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0" name="q" placeholder="Rechercher un concept, domaine..." type="text" value="{{ request('q') }}">
                        </label>
                    </form>
                    <div class="relative hidden sm:block" x-data="{ open: false }">
                        <button @click="open = !open" class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600" type="button">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082A23.848 23.848 0 0 1 12 17.25a23.848 23.848 0 0 1-2.857-.168m5.714 0a24.255 24.255 0 0 0 2.45-.434m-8.164.434a24.255 24.255 0 0 1-2.45-.434m10.614 0A5.982 5.982 0 0 0 18 13.5V9a6 6 0 1 0-12 0v4.5c0 1.18.343 2.28.936 3.207m10.128 0A24.255 24.255 0 0 1 12 17.25c-1.778 0-3.51-.194-5.143-.543" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20.25a3 3 0 0 0 6 0" />
                            </svg>
                            <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-indigo-500 px-1 text-[10px] font-bold text-white">
                                {{ min(($topbarNotifications['toReviewCount'] ?? 0) + ($topbarNotifications['archivedCount'] ?? 0), 9) }}
                            </span>
                        </button>

                        <div
                            x-cloak
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 top-14 z-30 w-[360px] rounded-[28px] border border-slate-200/80 bg-white p-4 shadow-[0_24px_60px_rgba(15,23,42,0.12)]"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Notifications</p>
                                    <p class="text-xs text-slate-500">Ce qui mérite ton attention maintenant.</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600">Ouvrir dashboard</a>
                            </div>

                            <div class="mt-4 space-y-3">
                                <a href="{{ route('concepts.index', ['status' => 'to_review']) }}" class="block rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $topbarNotifications['toReviewCount'] ?? 0 }} concepts à revoir</p>
                                    <p class="mt-1 text-xs text-slate-500">Accède directement aux fiches qui demandent une nouvelle passe.</p>
                                </a>

                                <a href="{{ route('archived-concepts.index') }}" class="block rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $topbarNotifications['archivedCount'] ?? 0 }} concepts archivés</p>
                                    <p class="mt-1 text-xs text-slate-500">Restaure une fiche si elle redevient utile pour les entretiens.</p>
                                </a>

                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-900">Dernières générations IA</p>
                                    <div class="mt-3 space-y-3">
                                        @forelse (($topbarNotifications['recentGenerations'] ?? collect()) as $generation)
                                            <a href="{{ route('domains.concepts.show', [$generation->concept->domain, $generation->concept]) }}" class="block text-sm text-slate-600 hover:text-slate-900">
                                                <span class="font-medium text-slate-900">{{ $generation->concept->title }}</span>
                                                <span class="block text-xs text-slate-500">{{ $generation->created_at->diffForHumans() }}</span>
                                            </a>
                                        @empty
                                            <p class="text-xs text-slate-500">Aucune génération récente.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl bg-white px-3 py-2 shadow-sm ring-1 ring-slate-200/80">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-500 text-sm font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="content-wrap">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
