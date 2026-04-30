<x-student-layout :title="$job->title">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Job Detail</p>
                        <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $job->title }}</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-500">
                            {{ $job->company->name }} • {{ $job->category }} • {{ strtoupper($job->work_type) }}
                            @if ($job->is_paid)
                                <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-black text-emerald-700 ring-1 ring-emerald-100">PAID</span>
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center rounded-2xl px-4 py-3 text-sm font-black ring-1
                            {{ $score >= 70 ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-amber-100' }}">
                            {{ $score }}% Match
                        </span>
                        @if ($isCompanyVerified)
                            <span class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 px-4 py-3 text-sm font-black text-indigo-700 ring-1 ring-indigo-100">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                                Company Verified
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 prose max-w-none prose-slate">
                    <p class="text-sm font-medium leading-relaxed text-slate-700 whitespace-pre-line">{{ $job->description }}</p>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Matching Analysis</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Skill fit breakdown</h3>
                    </div>
                    <span class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2.5 text-xs font-black text-white shadow-sm">
                        Requirements: {{ $job->skills->count() }}
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="rounded-2xl bg-emerald-50/60 p-6 ring-1 ring-emerald-100">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">Skill yang kamu miliki</p>
                        <div class="mt-4 space-y-2">
                            @forelse ($ownedSkills as $skill)
                                <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 ring-1 ring-emerald-100">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">✓</span>
                                        <p class="text-sm font-black text-slate-900">{{ $skill->name }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm font-semibold text-emerald-700">Belum ada skill yang match. Update skill profile untuk meningkatkan skor.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl bg-amber-50/60 p-6 ring-1 ring-amber-100">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-600">Skill yang perlu ditingkatkan</p>
                        <div class="mt-4 space-y-2">
                            @forelse ($gapSkills as $skill)
                                <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 ring-1 ring-amber-100">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 ring-1 ring-amber-100">!</span>
                                        <p class="text-sm font-black text-slate-900">{{ $skill->name }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm font-semibold text-amber-700">Tidak ada skill gap — kamu sudah memenuhi semua requirement.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200" x-data="{ openApply: false }">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Apply Now</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Ready to submit?</h3>
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    Pastikan profilmu lengkap sebelum apply agar peluang meningkat.
                </p>

                @if (session('status'))
                    <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm font-semibold text-slate-700 ring-1 ring-slate-200">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mt-6 rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-400">Profile completeness</p>
                        <p class="text-xs font-black text-slate-700">{{ $profileCompleteness }}%</p>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white ring-1 ring-slate-200">
                        <div class="h-2 rounded-full {{ $profileCompleteness >= 80 ? 'bg-emerald-500' : 'bg-amber-400' }}" style="width: {{ min(100, $profileCompleteness) }}%"></div>
                    </div>
                    @if ($profileCompleteness < 80)
                        <p class="mt-3 text-sm font-semibold text-amber-700">
                            Profilmu belum siap. Lengkapi hingga minimal 80% untuk bisa apply.
                        </p>
                        <a href="{{ route('student.profile.edit') }}" class="mt-4 inline-flex w-full justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">
                            Lengkapi Profile
                        </a>
                    @endif
                </div>

                <button type="button"
                    class="mt-4 w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600 disabled:cursor-not-allowed disabled:bg-slate-400"
                    @click="openApply = true"
                    @disabled($profileCompleteness < 80)>
                    Apply Now
                </button>

                <div x-show="openApply" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-slate-900/60" @click="openApply = false"></div>
                    <div class="relative w-full max-w-xl rounded-3xl bg-white p-8 shadow-2xl ring-1 ring-slate-200">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Application Flow</p>
                                <h4 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Submit application</h4>
                                <p class="mt-2 text-sm font-semibold text-slate-500">
                                    Checklist validation memastikan profilmu siap.
                                </p>
                            </div>
                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 ring-1 ring-slate-200 hover:ring-indigo-300" @click="openApply = false">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-6 rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                            <p class="text-sm font-bold text-slate-700">Checklist Validation</p>
                            <ul class="mt-4 space-y-2 text-sm font-semibold text-slate-600">
                                <li class="flex items-center justify-between rounded-xl bg-white px-4 py-3 ring-1 ring-slate-200">
                                    <span>Profile completeness ≥ 80%</span>
                                    <span class="font-black text-emerald-600">✓</span>
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('student.jobs.apply', $job) }}" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Cover letter (optional)</label>
                                <textarea name="cover_letter" rows="5"
                                    class="mt-2 w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Kenapa kamu kandidat yang tepat?"></textarea>
                                @error('cover_letter')
                                    <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                                Confirm & Submit
                            </button>
                        </form>
                    </div>
                </div>

                <a href="{{ route('student.jobs.index') }}" class="mt-4 inline-flex w-full justify-center rounded-2xl bg-white px-6 py-4 text-sm font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">
                    Back to Job Board
                </a>
            </div>
        </div>
    </div>
</x-student-layout>

