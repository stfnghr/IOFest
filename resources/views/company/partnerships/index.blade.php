<x-company-layout title="University Marketplace">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm font-semibold text-slate-600">Ajukan kerja sama ke universitas target. Status akan diproses Admin Universitas.</p>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4">
        @foreach ($universities as $university)
            @php
                $current = $statusMap[$university->id] ?? null;
                $status = $current['status'] ?? 'not_requested';
            @endphp
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-lg font-black text-slate-900">{{ $university->name }}</p>
                        <p class="mt-1 text-sm font-semibold text-slate-500">Status Partnership:
                            <span class="font-black
                                {{ $status === 'verified' ? 'text-emerald-600' : '' }}
                                {{ $status === 'pending' ? 'text-amber-600' : '' }}
                                {{ $status === 'rejected' ? 'text-rose-600' : '' }}
                                {{ $status === 'not_requested' ? 'text-slate-500' : '' }}">
                                {{ str($status)->replace('_', ' ')->title() }}
                            </span>
                        </p>
                    </div>
                    <form method="POST" action="{{ route('company.partnerships.request', $university) }}">
                        @csrf
                        <button class="rounded-xl bg-violet-600 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">
                            Ajukan Kerja Sama
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-company-layout>

