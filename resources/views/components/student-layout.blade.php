@props(['title' => null])

<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto flex max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:px-8">
            <aside class="hidden w-72 shrink-0 lg:block">
                <div class="rounded-3xl bg-slate-900 p-6 text-white shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-white/60">UC HUB</p>
                            <p class="mt-1 text-lg font-black tracking-tight">Student Portal</p>
                        </div>
                        <span class="inline-flex items-center rounded-2xl bg-white/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white/80 ring-1 ring-white/10">
                            {{ auth()->user()->university?->name ?? 'University' }}
                        </span>
                    </div>

                    <nav class="mt-8 space-y-2">
                        <a href="{{ route('student.dashboard') }}"
                            class="{{ request()->routeIs('student.dashboard') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Dashboard
                        </a>
                        <a href="{{ route('student.jobs.index') }}"
                            class="{{ request()->routeIs('student.jobs.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Job Board
                        </a>
                        <a href="{{ route('student.applications.index') }}"
                            class="{{ request()->routeIs('student.applications.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Applications
                        </a>
                        <a href="{{ route('student.profile.edit') }}"
                            class="{{ request()->routeIs('student.profile.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Profile & CV
                        </a>
                        <a href="{{ route('student.journals.index') }}"
                            class="{{ request()->routeIs('student.journals.*') ? 'bg-white/10 ring-1 ring-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-black tracking-tight transition">
                            Journal
                        </a>
                    </nav>

                    <div class="mt-10 rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-white/60">Status</p>
                        <p class="mt-2 text-sm font-bold text-white/90">
                            {{ auth()->user()->studentProfile?->status ?? 'pending_validation' }}
                        </p>
                        <p class="mt-2 text-xs font-semibold text-white/60">
                            Akun manual fallback perlu divalidasi Admin Universitas sebelum apply penuh.
                        </p>
                    </div>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Student</p>
                        <h1 class="mt-1 text-3xl font-black tracking-tight text-slate-900">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300"
                            title="Notifications">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M18 17V11a6 6 0 1 0-12 0v6l-2 2h16l-2-2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            </svg>
                            <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-400 px-1 text-[10px] font-black text-slate-900">
                                0
                            </span>
                        </button>

                        <div class="hidden rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200 sm:block">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Signed in as</p>
                            <p class="mt-1 text-sm font-black text-slate-900">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>

