<x-company-layout title="Candidate Pipeline">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <aside class="lg:col-span-4 xl:col-span-3">
            <form method="GET" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Smart Filter</p>
                    <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Refine candidates</h2>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Filter cepat untuk screening kandidat.</p>
                </div>
                <div>
                    <label class="text-xs font-black uppercase tracking-[0.1em] text-slate-600">University</label>
                    <select name="university_id" class="mt-2 w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500">
                        <option value="">All</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}" @selected((int) request('university_id') === (int) $university->id)>{{ $university->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-black uppercase tracking-[0.1em] text-slate-600">Minimum Match Rate</label>
                    <input name="min_match_rate" value="{{ request('min_match_rate') }}" type="number" min="0" max="100" class="mt-2 w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500" />
                </div>
                <div>
                    <label class="text-xs font-black uppercase tracking-[0.1em] text-slate-600">Job Title</label>
                    <select name="job_id" class="mt-2 w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500">
                        <option value="">All</option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->id }}" @selected((int) request('job_id') === (int) $job->id)>{{ $job->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="w-full rounded-xl bg-violet-600 px-4 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">Apply</button>
            </form>
        </aside>

        <div class="lg:col-span-8 xl:col-span-9">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Candidate</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">University</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Job</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Match</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($applications as $application)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-black text-slate-900">{{ $application->user->name }}</p>
                                    <p class="text-xs font-semibold text-slate-500">{{ $application->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-slate-700">
                                        {{ $application->user->university?->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $application->job->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest
                                        {{ $application->match_score >= 70 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ $application->match_score }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('company.candidates.show', $application) }}" class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-black text-white shadow-sm hover:bg-violet-700">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm font-semibold text-slate-500">No candidates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-company-layout>

