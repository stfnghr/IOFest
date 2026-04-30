<x-univ-layout title="Analytics">
    <div class="mb-6">
        <a href="{{ route('university.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Skill-Gap Map</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Top demanded vs available skills</h2>
                <p class="mt-2 text-sm font-semibold text-slate-500">Demand dari requirement lowongan yang menarget kampus ini.</p>

                <div class="mt-6 space-y-3">
                    @forelse ($skillGap as $row)
                        <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-black text-slate-900">{{ $row['name'] }}</p>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">
                                    Demand <span class="text-slate-700">{{ $row['demand'] }}</span> • Supply <span class="text-slate-700">{{ $row['supply'] }}</span>
                                </p>
                            </div>
                            @php
                                $max = max($row['demand'], 1);
                                $supplyPct = min(100, (int) round(($row['supply'] / $max) * 100));
                            @endphp
                            <div class="mt-3 h-2 rounded-full bg-white ring-1 ring-slate-200">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $supplyPct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-slate-500">No data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Internship Rate</p>
                <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $internshipRate }}%</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    {{ $acceptedStudents }} dari {{ $totalStudents }} mahasiswa sedang accepted.
                </p>
            </div>
        </div>
    </div>
</x-univ-layout>

