<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900">Initial Career Interest</h1>
                        <p class="mt-2 text-sm font-medium text-slate-500">
                            Pilih preferensi kerja dan minat karier untuk menyalakan fitur rekomendasi UC HUB.
                        </p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-black text-indigo-700">
                        Onboarding
                    </span>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-6">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-400">Work preference</p>
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <button type="button" class="rounded-xl bg-white px-4 py-3 text-sm font-bold text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">Remote</button>
                            <button type="button" class="rounded-xl bg-white px-4 py-3 text-sm font-bold text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">Hybrid</button>
                            <button type="button" class="rounded-xl bg-white px-4 py-3 text-sm font-bold text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">On-site</button>
                        </div>
                        <p class="mt-3 text-xs font-semibold text-slate-400">UI placeholder (Phase 2 akan menyimpan ke `user_preferences`).</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-6">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-400">Interest categories</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach (['Frontend', 'Backend', 'Data', 'UI/UX', 'Product', 'HR', 'Marketing'] as $chip)
                                <span class="inline-flex items-center rounded-full bg-white px-3 py-1.5 text-xs font-bold text-slate-700 ring-1 ring-slate-200">
                                    {{ $chip }}
                                </span>
                            @endforeach
                        </div>
                        <p class="mt-3 text-xs font-semibold text-slate-400">UI placeholder (Phase 2 akan pilih minimal 3).</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">
                        Skip for now
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                        Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

