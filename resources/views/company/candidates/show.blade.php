<x-company-layout title="Candidate Detail">
    <div class="mb-6">
        <a href="{{ route('company.candidates.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm hover:bg-slate-200">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="text-xl font-black text-slate-900">{{ $application->user->name }}</h2>
                <p class="mt-1 text-sm font-semibold text-slate-500">{{ $application->user->email }}</p>
                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-400">NIM</p>
                        <p class="mt-1 font-semibold text-slate-700">{{ $application->user->studentProfile?->nim ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-400">Major</p>
                        <p class="mt-1 font-semibold text-slate-700">{{ $application->user->studentProfile?->major ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-400">Faculty</p>
                        <p class="mt-1 font-semibold text-slate-700">{{ $application->user->studentProfile?->faculty ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-400">University</p>
                        <p class="mt-1 font-semibold text-slate-700">{{ $application->user->university?->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h3 class="text-lg font-black text-slate-900">Skill-Gap Analysis</h3>
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-xl bg-emerald-50/50 p-4 ring-1 ring-emerald-100">
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-emerald-600">Skills matched</p>
                        <div class="mt-2 space-y-2">
                            @forelse ($ownedSkills as $skill)
                                <div class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-700 ring-1 ring-emerald-100">✓ {{ $skill->name }}</div>
                            @empty
                                <p class="text-sm font-semibold text-slate-500">No matched skills.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="rounded-xl bg-amber-50/50 p-4 ring-1 ring-amber-100">
                        <p class="text-xs font-black uppercase tracking-[0.1em] text-amber-600">Gaps</p>
                        <div class="mt-2 space-y-2">
                            @forelse ($gapSkills as $skill)
                                <div class="rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-700 ring-1 ring-amber-100">! {{ $skill->name }}</div>
                            @empty
                                <p class="text-sm font-semibold text-slate-500">No skill gaps.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Match Score</p>
                <p class="mt-2 text-4xl font-black {{ $matchScore >= 70 ? 'text-emerald-600' : 'text-amber-600' }}">{{ $matchScore }}%</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Current status: <span class="font-black">{{ $application->status }}</span></p>

                <div class="mt-6 space-y-3">
                    <form method="POST" action="{{ route('company.candidates.decide', $application) }}">
                        @csrf
                        <input type="hidden" name="decision" value="reject">
                        <button class="w-full rounded-xl bg-rose-500 px-4 py-3 text-xs font-black text-white shadow-sm hover:bg-rose-600">Reject</button>
                    </form>
                    <form method="POST" action="{{ route('company.candidates.decide', $application) }}">
                        @csrf
                        <input type="hidden" name="decision" value="interview">
                        <button class="w-full rounded-xl bg-amber-400 px-4 py-3 text-xs font-black text-slate-900 shadow-sm hover:bg-amber-500">Interview</button>
                    </form>
                    <form method="POST" action="{{ route('company.candidates.decide', $application) }}">
                        @csrf
                        <input type="hidden" name="decision" value="hire">
                        <button class="w-full rounded-xl bg-violet-600 px-4 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">Hire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-company-layout>

