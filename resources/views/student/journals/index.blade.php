<x-student-layout title="Daily Journal & Logbook">
    @if (session('status'))
        <div class="mb-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-700">{{ session('status') }}</p>
        </div>
    @endif

    <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200" x-data="{ selectedAppId: {{ $acceptedApplications->first()?->id ?? 'null' }}, selectedDate: '{{ now()->toDateString() }}' }">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Logbook</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Daily Journal</h2>
                <p class="mt-2 text-sm font-semibold text-slate-500">Tersedia hanya untuk aplikasi yang sudah Accepted.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <select class="rounded-2xl border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    x-model="selectedAppId">
                    @foreach ($acceptedApplications as $application)
                        <option value="{{ $application->id }}">
                            {{ $application->job->title }} — {{ $application->job->company->name }}
                        </option>
                    @endforeach
                </select>

                <template x-if="selectedAppId">
                    <a class="inline-flex justify-center rounded-2xl bg-slate-900 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-indigo-600"
                        :href="`/student/journals/${selectedAppId}/print`">
                        Generate Logbook PDF
                    </a>
                </template>
            </div>
        </div>

        @if ($acceptedApplications->isEmpty())
            <div class="mt-8 rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                <p class="text-sm font-semibold text-slate-600">Belum ada aplikasi Accepted, jadi jurnal belum aktif.</p>
            </div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="lg:col-span-4">
                    <div class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Calendar</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Pilih tanggal entri.</p>

                        <div class="mt-4">
                            <input type="date" x-model="selectedDate"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="mt-6 rounded-2xl bg-white p-5 ring-1 ring-slate-200">
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Selected</p>
                            <p class="mt-2 text-sm font-black text-slate-900" x-text="selectedDate"></p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Daily Form</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Apa yang kamu kerjakan hari ini?</p>

                        <template x-for="application in {{ $acceptedApplications->toJson(JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) }}" :key="application.id">
                            <div x-show="parseInt(selectedAppId) === parseInt(application.id)" x-cloak class="mt-6">
                                <form method="POST" :action="`/student/journals/${application.id}`" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="date" :value="selectedDate" />
                                    <textarea name="content" rows="8"
                                        class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold leading-relaxed text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Tuliskan ringkas namun jelas…"></textarea>

                                    <button class="inline-flex w-full justify-center rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                                        Save Journal Entry
                                    </button>
                                </form>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-student-layout>

