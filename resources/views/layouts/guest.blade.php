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
    <div class="min-h-screen px-4 py-6 sm:px-7">
        <div class="mx-auto grid min-h-[calc(100vh-3rem)] max-w-[1160px] overflow-hidden rounded-[30px] border border-slate-200/80 bg-white/80 shadow-[0_24px_70px_rgba(15,23,42,0.07)] backdrop-blur-xl lg:grid-cols-[minmax(320px,460px)_minmax(420px,560px)] lg:justify-center">
            <section class="hidden bg-gradient-to-br from-white via-white to-violet-50/70 lg:flex lg:flex-col lg:justify-between lg:p-10">
                <div class="space-y-8">
                    <a href="/" class="flex items-center gap-4">
                        <x-application-logo class="h-14 w-14 shrink-0" />
                        <div>
                            <p class="text-2xl font-extrabold tracking-tight text-slate-950">InterviewPrep</p>
                            <p class="text-2xl font-extrabold tracking-tight text-indigo-600">Laravel</p>
                        </div>
                    </a>

                    <div class="mx-auto flex h-60 w-60 items-end justify-center rounded-full bg-gradient-to-br from-violet-100 to-indigo-50">
                        <div class="relative mb-7 h-36 w-24">
                            <div class="absolute inset-x-3 top-0 h-20 rounded-t-full rounded-b-[42%] bg-white shadow-[0_14px_42px_rgba(99,102,241,0.18)]"></div>
                            <div class="absolute left-1/2 top-10 h-6 w-6 -translate-x-1/2 rounded-full bg-violet-300 ring-4 ring-indigo-50"></div>
                            <div class="absolute left-0 top-12 h-10 w-5 -translate-x-2 rotate-[22deg] rounded-l-full rounded-r-sm bg-indigo-500"></div>
                            <div class="absolute right-0 top-12 h-10 w-5 translate-x-2 -rotate-[22deg] rounded-r-full rounded-l-sm bg-indigo-500"></div>
                            <div class="absolute bottom-0 left-1/2 h-16 w-4 -translate-x-1/2 rounded-b-full bg-indigo-500"></div>
                            <div class="absolute bottom-5 left-[-20px] h-3.5 w-3.5 rounded-xl bg-violet-200"></div>
                            <div class="absolute top-10 right-[-16px] h-4 w-4 rounded-xl bg-indigo-100"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <div>
                        <h2 class="text-[2.15rem] font-extrabold leading-tight tracking-tight text-slate-950">Preparez-vous. Progressez. Reussissez.</h2>
                        <p class="mt-3 max-w-md text-base leading-7 text-slate-500">InterviewPrep Laravel vous aide a structurer vos connaissances et a vous entrainer efficacement.</p>
                    </div>

                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-indigo-600">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="4" width="7" height="7" rx="1.5" />
                                    <rect x="13" y="4" width="7" height="7" rx="1.5" />
                                    <rect x="4" y="13" width="7" height="7" rx="1.5" />
                                    <rect x="13" y="13" width="7" height="7" rx="1.5" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Organisez vos domaines</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Structurez vos connaissances par domaines et sous-domaines pour un apprentissage clair.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-indigo-600">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="7.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.2 2.2L15.8 9" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Suivez votre maitrise</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Visualisez votre progression et concentrez-vous sur ce qui compte vraiment.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-indigo-600">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 6.5 5 12l3.5 5.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 6.5 19 12l-3.5 5.5" />
                                    <path stroke-linecap="round" d="m13 5-2 14" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Generez des questions d'entretien</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Entrainez-vous avec des questions IA adaptees a vos domaines et a votre niveau.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="flex items-center justify-center bg-[linear-gradient(180deg,rgba(252,252,255,0.82),rgba(248,250,252,0.92))] p-5 sm:p-7 lg:p-9">
                <div class="w-full max-w-[520px]">
                    <div class="rounded-[28px] border border-white/70 bg-white/55 p-2 shadow-[0_10px_30px_rgba(15,23,42,0.04)] backdrop-blur-sm">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
