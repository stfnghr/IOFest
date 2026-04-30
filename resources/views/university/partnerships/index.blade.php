<x-univ-layout title="Partnerships">
    <div class="mb-6">
        <a href="{{ route('university.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-7 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Incoming Requests</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Companies awaiting approval</h2>

                <div class="mt-6 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                    <table class="min-w-full divide-y divide-slate-100 bg-white">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Company</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($incoming as $company)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-black text-slate-900">{{ $company->name }}</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-500">{{ $company->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <form method="POST" action="{{ route('university.partnerships.approve', $company) }}">
                                                @csrf
                                                <button class="rounded-2xl bg-slate-900 px-4 py-2.5 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('university.partnerships.reject', $company) }}">
                                                @csrf
                                                <button class="rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 ring-1 ring-slate-200 hover:ring-rose-300">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-sm font-semibold text-slate-500">No incoming requests.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Active Partners</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Verified companies</h2>

                <div class="mt-6 space-y-3">
                    @forelse ($active as $company)
                        @php
                            $pivot = $company->universities->first()?->pivot;
                        @endphp
                        <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                            <p class="text-sm font-black text-slate-900">{{ $company->name }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $company->email }}</p>
                            <p class="mt-3 text-xs font-black uppercase tracking-widest text-slate-400">
                                MoU expires: <span class="text-slate-700">{{ $pivot?->mou_expires_at ?? '-' }}</span>
                            </p>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-slate-500">No active partners yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-univ-layout>

