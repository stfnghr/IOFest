<x-company-layout title="Internship Monitoring">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm font-semibold text-slate-600">One-click approval untuk jurnal harian mahasiswa accepted interns.</p>
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($journals as $journal)
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-900">{{ $journal->application->user->name }} • {{ $journal->application->job->title }}</p>
                        <p class="mt-1 text-xs font-semibold text-slate-500">{{ $journal->application->user->university?->name }} • {{ $journal->date->toDateString() }}</p>
                        <p class="mt-3 text-sm font-medium text-slate-700">{{ $journal->content }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($journal->approved_at)
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-700">
                                Approved
                            </span>
                        @else
                            <form method="POST" action="{{ route('company.interns.approve', $journal) }}">
                                @csrf
                                <button class="rounded-xl bg-violet-600 px-4 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">
                                    Approve
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-semibold text-slate-500">Belum ada jurnal interns.</p>
            </div>
        @endforelse
    </div>
</x-company-layout>

