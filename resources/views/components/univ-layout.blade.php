@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ? $title.' • ' : '' }}UC HUB - University Admin</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900">
        <div class="min-h-screen bg-slate-50 pl-0 lg:pl-80">
            <aside class="fixed inset-y-0 left-0 hidden w-80 p-6 lg:block">
                <div class="flex h-[calc(100vh-3rem)] flex-col rounded-3xl bg-slate-900 p-6 shadow-sm ring-1 ring-white/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-black tracking-tight text-white">UC HUB</p>
                            <p class="mt-1 text-xs font-black uppercase tracking-[0.2em] text-slate-400">University Admin</p>
                        </div>
                        <span class="inline-flex items-center rounded-2xl bg-white/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white/80 ring-1 ring-white/10">
                            {{ auth()->user()->university?->name ?? 'University' }}
                        </span>
                    </div>

                    <nav class="mt-8 space-y-2">
                        <a href="{{ route('university.dashboard') }}"
                            class="{{ request()->routeIs('university.dashboard') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Dashboard
                        </a>
                        <a href="{{ route('university.partnerships.index') }}"
                            class="{{ request()->routeIs('university.partnerships.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Partnerships
                        </a>
                        <a href="{{ route('university.students.validate') }}"
                            class="{{ request()->routeIs('university.students.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Student Validation
                        </a>
                        <a href="{{ route('university.analytics.index') }}"
                            class="{{ request()->routeIs('university.analytics.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Analytics
                        </a>
                        <a href="{{ route('university.majors.index') }}"
                            class="{{ request()->routeIs('university.majors.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Majors
                        </a>
                        <a href="{{ route('university.skills.index') }}"
                            class="{{ request()->routeIs('university.skills.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Skills
                        </a>
                    </nav>

                    <div class="mt-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full rounded-2xl bg-white/10 px-4 py-3 text-sm font-black text-slate-200 ring-1 ring-white/10 hover:bg-white/20 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">University</p>
                        <h1 class="mt-1 text-3xl font-black tracking-tight text-slate-900">{{ $title ?? 'Dashboard' }}</h1>
                    </div>

                    <div class="hidden rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200 sm:block">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Signed in as</p>
                        <p class="mt-1 text-sm font-black text-slate-900">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-bold text-slate-600">{{ session('status') }}</p>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </body>
</html>

