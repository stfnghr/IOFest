<x-student-layout title="Dashboard">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Lamaran Aktif</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $activeApplicationsCount }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Cek status terbaru.</p>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-500">Undangan Interview</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $interviewInvitesCount }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Perlu respons cepat.</p>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Match Score</p>
                    <div class="mt-3 flex items-end gap-3">
                        <p class="text-4xl font-black tracking-tight text-slate-900">{{ $averageMatch }}</p>
                        <p class="pb-1 text-sm font-black text-slate-400">avg</p>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Rata-rata kesesuaian.</p>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Recommended Feed</p>
                        <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Top matches for you</h2>
                    </div>
                    <a href="{{ route('student.jobs.index') }}" class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2.5 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                        Explore jobs
                    </a>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ($recommended as $row)
                        @php
                            $job = $row['job'];
                            $score = $row['score'];
                        @endphp
                        <a href="{{ route('student.jobs.show', $job) }}" class="group block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 hover:ring-indigo-300">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-black text-slate-900 group-hover:text-indigo-700">{{ $job->title }}</p>
                                    <p class="mt-1 truncate text-sm font-semibold text-slate-500">
                                        {{ $job->company->name }} • {{ $job->category }} • {{ strtoupper($job->work_type) }}
                                        @if ($job->is_paid)
                                            <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-black text-emerald-700 ring-1 ring-emerald-100">PAID</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center rounded-2xl px-3 py-2 text-xs font-black ring-1
                                        {{ $score >= 70 ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-amber-100' }}">
                                        {{ $score }}%
                                    </span>
                                    <svg class="h-5 w-5 text-slate-400 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Skill Radar</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Your skill snapshot</h2>
                <p class="mt-2 text-sm font-semibold text-slate-500">Visual cepat untuk melihat kekuatanmu.</p>

                <div class="mt-6">
                    <svg viewBox="0 0 240 240" class="mx-auto h-56 w-56">
                        <circle cx="120" cy="120" r="92" fill="none" stroke="#e2e8f0" stroke-width="2" />
                        <circle cx="120" cy="120" r="62" fill="none" stroke="#e2e8f0" stroke-width="2" />
                        <circle cx="120" cy="120" r="32" fill="none" stroke="#e2e8f0" stroke-width="2" />

                        @php
                            $points = [];
                            $count = max($skillRadar->count(), 1);
                            foreach ($skillRadar as $i => $item) {
                                $angle = (2 * pi() * $i / $count) - (pi() / 2);
                                $radius = 92 * ($item['value'] / 100);
                                $x = 120 + cos($angle) * $radius;
                                $y = 120 + sin($angle) * $radius;
                                $points[] = "{$x},{$y}";
                            }
                        @endphp

                        @if (count($points) > 2)
                            <polygon points="{{ implode(' ', $points) }}" fill="rgba(99,102,241,0.18)" stroke="#6366f1" stroke-width="2" />
                        @endif

                        @foreach ($skillRadar as $i => $item)
                            @php
                                $angle = (2 * pi() * $i / $count) - (pi() / 2);
                                $x = 120 + cos($angle) * 104;
                                $y = 120 + sin($angle) * 104;
                            @endphp
                            <text x="{{ $x }}" y="{{ $y }}" text-anchor="middle" dominant-baseline="middle" font-size="10" fill="#475569">
                                {{ \Illuminate\Support\Str::limit($item['label'], 10) }}
                            </text>
                        @endforeach
                    </svg>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ($skillRadar as $item)
                        <div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-black text-slate-700">{{ $item['label'] }}</p>
                                <p class="text-xs font-black text-slate-400">{{ $item['value'] }}%</p>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $item['value'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Next action</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Complete your profile</h2>
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    Profil lengkap meningkatkan peluangmu. Pastikan skills & preferensi sudah terisi.
                </p>
                <a href="{{ route('student.profile.edit') }}" class="mt-5 inline-flex w-full justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                    Update Profile & CV
                </a>
            </div>
        </div>
    </div>
</x-student-layout>

