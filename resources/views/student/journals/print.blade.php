<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UC HUB Logbook</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white text-slate-900">
        <div class="mx-auto max-w-3xl px-6 py-10">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">UC HUB</p>
                    <h1 class="mt-2 text-3xl font-black tracking-tight">Logbook Recap</h1>
                    <p class="mt-2 text-sm font-semibold text-slate-600">
                        {{ $application->job->title }} — {{ $application->job->company->name }}
                    </p>
                </div>
                <button onclick="window.print()" class="rounded-2xl bg-slate-900 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-indigo-600 print:hidden">
                    Print / Save as PDF
                </button>
            </div>

            <div class="mt-8 rounded-3xl border border-slate-200 p-6">
                <p class="text-sm font-black text-slate-900">Student</p>
                <p class="mt-2 text-sm font-semibold text-slate-600">{{ auth()->user()->name }} • {{ auth()->user()->email }}</p>
            </div>

            <div class="mt-8 space-y-4">
                @forelse ($application->internshipJournals->sortBy('date') as $entry)
                    <div class="rounded-3xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-black text-slate-900">{{ \Illuminate\Support\Carbon::parse($entry->date)->toFormattedDateString() }}</p>
                            @if ($entry->approved_at)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-700 ring-1 ring-emerald-100">
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-700 ring-1 ring-amber-100">
                                    Pending
                                </span>
                            @endif
                        </div>
                        <p class="mt-3 whitespace-pre-line text-sm font-medium leading-relaxed text-slate-700">{{ $entry->content }}</p>
                    </div>
                @empty
                    <div class="rounded-3xl border border-slate-200 p-10 text-center">
                        <p class="text-sm font-semibold text-slate-600">Belum ada entri jurnal.</p>
                    </div>
                @endforelse
            </div>

            <p class="mt-10 text-center text-xs font-bold text-slate-400">
                Generated from UC HUB — print to PDF for submission.
            </p>
        </div>
    </body>
</html>

