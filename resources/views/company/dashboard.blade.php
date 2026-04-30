<x-company-layout title="Dashboard Utama">
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-slate-900">Dashboard Utama</h2>
                <p class="mt-2 text-sm font-semibold text-slate-500">Pantau kandidat, match rate, dan SLA hiring.</p>
            </div>

            <form method="GET" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                <select name="university_id" class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:w-72">
                    <option value="">All Partner Universities</option>
                    @foreach ($verifiedUniversities as $university)
                        <option value="{{ $university->id }}" @selected((int) $selectedUniversityId === (int) $university->id)>{{ $university->name }}</option>
                    @endforeach
                </select>
                <input name="q" value="{{ request('q') }}" placeholder="Search candidate/job..."
                    class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:w-72" />
                <button class="rounded-2xl bg-violet-600 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-violet-700">
                    Apply
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Total Kandidat</p>
                <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $totalApplicants }}</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Semua pelamar dari universitas partner.</p>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Rata-rata Match Rate</p>
                <p class="mt-3 text-4xl font-black tracking-tight text-emerald-600">{{ $avgMatch }}%</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Kualitas kandidat vs requirement.</p>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Hired Interns</p>
                <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $hiredInterns }}</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Kandidat yang sudah accepted.</p>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 {{ $slaWarning > 0 ? 'ring-rose-200' : 'ring-slate-200' }}">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] {{ $slaWarning > 0 ? 'text-rose-500' : 'text-slate-400' }}">SLA Warning</p>
                    <p class="mt-2 text-3xl font-black {{ $slaWarning > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $slaWarning }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Applications &gt; 5 hari pending.</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl {{ $slaWarning > 0 ? 'bg-rose-50 text-rose-600 ring-1 ring-rose-100' : 'bg-slate-50 text-slate-500 ring-1 ring-slate-200' }}">
                    {{ $slaWarning > 0 ? '!' : '✓' }}
                </span>
            </div>
        </div>
    </div>
</x-company-layout>

