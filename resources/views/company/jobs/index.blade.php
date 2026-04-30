<x-company-layout title="Job Management">
    <div class="flex items-center justify-between rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm font-semibold text-slate-600">Kelola lowongan aktif dan closed milik perusahaan Anda.</p>
        <a href="{{ route('company.jobs.create') }}" class="rounded-xl bg-violet-600 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">+ Create Job</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Applicants</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.1em] text-slate-400">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($jobs as $job)
                    <tr>
                        <td class="px-6 py-4">
                            <p class="text-sm font-black text-slate-900">{{ $job->title }}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ strtoupper($job->work_type) }} • {{ $job->duration }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $job->category }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $job->applications_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest
                                {{ $job->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $job->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm font-semibold text-slate-500">Belum ada lowongan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-company-layout>

