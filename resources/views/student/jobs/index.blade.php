<x-student-layout title="Job Board">
    <div x-data="{ quickOpen: false, quickJob: null }">
        <div class="sticky top-0 z-10 -mx-4 mb-6 bg-slate-50/90 px-4 py-4 backdrop-blur sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <form method="GET" action="{{ route('student.jobs.index') }}" class="grid grid-cols-1 gap-3 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <input name="q" value="{{ request('q') }}"
                        placeholder="Search role, company, or keywords…"
                        class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>

                <div class="lg:col-span-3">
                    <select name="category" class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-3">
                    <select name="work_type" class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All types</option>
                        <option value="remote" @selected(request('work_type') === 'remote')>Remote</option>
                        <option value="hybrid" @selected(request('work_type') === 'hybrid')>Hybrid</option>
                        <option value="on-site" @selected(request('work_type') === 'on-site')>On-site</option>
                    </select>
                </div>

                <div class="lg:col-span-1 flex items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200">
                        <input type="checkbox" name="paid" value="1" @checked(request()->boolean('paid')) class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                        Paid
                    </label>
                    <button class="inline-flex h-12 items-center justify-center rounded-2xl bg-slate-900 px-5 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            @foreach ($jobs as $job)
                @php
                    $score = (int) ($job->match_score ?? 0);
                @endphp
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="truncate text-lg font-black tracking-tight text-slate-900">{{ $job->title }}</p>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">
                                {{ $job->company->name }} • {{ $job->category }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest ring-1
                                    {{ $job->work_type === 'remote' ? 'bg-indigo-50 text-indigo-700 ring-indigo-100' : '' }}
                                    {{ $job->work_type === 'hybrid' ? 'bg-slate-50 text-slate-700 ring-slate-200' : '' }}
                                    {{ $job->work_type === 'on-site' ? 'bg-sky-50 text-sky-700 ring-sky-100' : '' }}">
                                    {{ $job->work_type }}
                                </span>
                                @if ($job->is_paid)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-700 ring-1 ring-emerald-100">
                                        Paid
                                    </span>
                                @endif
                                <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-[10px] font-black uppercase tracking-widest text-slate-500 ring-1 ring-slate-200">
                                    {{ $job->duration }}
                                </span>
                            </div>
                        </div>

                        <div class="shrink-0">
                            <div class="relative h-14 w-14">
                                <svg class="h-14 w-14 -rotate-90" viewBox="0 0 36 36">
                                    <path
                                        d="M18 2.0845
                                           a 15.9155 15.9155 0 0 1 0 31.831
                                           a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="#e2e8f0"
                                        stroke-width="3"
                                    />
                                    <path
                                        d="M18 2.0845
                                           a 15.9155 15.9155 0 0 1 0 31.831
                                           a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="{{ $score >= 70 ? '#10b981' : '#f59e0b' }}"
                                        stroke-width="3"
                                        stroke-dasharray="{{ $score }}, 100"
                                        stroke-linecap="round"
                                    />
                                </svg>
                                <div class="absolute inset-0 grid place-items-center">
                                    <span class="text-xs font-black text-slate-900">{{ $score }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('student.jobs.show', $job) }}" class="inline-flex flex-1 justify-center rounded-2xl bg-slate-900 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                            View details
                        </a>
                        <button type="button"
                            class="inline-flex flex-1 justify-center rounded-2xl bg-white px-5 py-3 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300"
                            @click="quickJob = {{ $job->toJson(JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) }}; quickOpen = true">
                            Quick view
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $jobs->links() }}
        </div>

        <div x-show="quickOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60" @click="quickOpen = false"></div>
            <div class="relative w-full max-w-2xl rounded-3xl bg-white p-8 shadow-2xl ring-1 ring-slate-200">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Quick View</p>
                        <h3 class="mt-2 truncate text-2xl font-black tracking-tight text-slate-900" x-text="quickJob?.title"></h3>
                        <p class="mt-2 text-sm font-semibold text-slate-500">
                            <span x-text="quickJob?.category"></span> • <span x-text="quickJob?.duration"></span>
                        </p>
                    </div>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 ring-1 ring-slate-200 hover:ring-indigo-300" @click="quickOpen = false">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="mt-6 rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                    <p class="text-sm font-bold text-slate-700">Job description (preview)</p>
                    <p class="mt-2 text-sm font-medium leading-relaxed text-slate-600" x-text="quickJob?.description"></p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" class="inline-flex justify-center rounded-2xl bg-white px-5 py-3 text-xs font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300" @click="quickOpen = false">
                        Close
                    </button>
                    <template x-if="quickJob?.id">
                        <a class="inline-flex justify-center rounded-2xl bg-slate-900 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-indigo-600"
                            :href="`/student/jobs/${quickJob.id}`">
                            Open full page
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>

