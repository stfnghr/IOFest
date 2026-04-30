<x-student-layout title="Applications">
    @if (session('status'))
        <div class="mb-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-700">{{ session('status') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        @foreach (['applied' => 'Applied', 'under_review' => 'Under Review', 'interview' => 'Interview', 'decision' => 'Decision'] as $key => $label)
            @php
                $items = collect();
                if ($key === 'decision') {
                    $items = $applications->whereIn('status', ['accepted', 'rejected']);
                } else {
                    $items = $applications->where('status', $key);
                }
            @endphp

            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">{{ $label }}</p>
                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-black text-slate-700 ring-1 ring-slate-200">
                        {{ $items->count() }}
                    </span>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($items as $application)
                        @php
                            $slaBreached = (bool) ($application->sla_breached ?? false);
                            $slaDays = (int) ($application->sla_days ?? 0);
                        @endphp
                        <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-sm font-black text-slate-900">{{ $application->job->title }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $application->job->company->name }}</p>

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-slate-500 ring-1 ring-slate-200">
                                    {{ $application->status }}
                                </span>

                                @if ($application->status === 'interview')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-amber-700 ring-1 ring-amber-100">
                                        Interview
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4">
                                <div class="h-2 rounded-full bg-white ring-1 ring-slate-200">
                                    <div class="h-2 rounded-full {{ $slaBreached ? 'bg-rose-500' : 'bg-emerald-500' }}"
                                        style="width: {{ min(100, (int) round(($slaDays / 7) * 100)) }}%"></div>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-xs font-black uppercase tracking-widest {{ $slaBreached ? 'text-rose-600' : 'text-slate-400' }}">
                                        SLA {{ $slaDays }}d / 7d
                                    </p>
                                    @if ($slaBreached && in_array($application->status, ['applied', 'under_review'], true))
                                        <form method="POST" action="{{ route('student.applications.request-intervention', $application) }}">
                                            @csrf
                                            <button class="rounded-xl bg-rose-50 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-rose-700 ring-1 ring-rose-100 hover:bg-rose-100">
                                                Request Campus Intervention
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                            <p class="text-sm font-semibold text-slate-500">Belum ada data.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</x-student-layout>

