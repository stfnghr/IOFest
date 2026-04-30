<x-univ-layout title="Majors">
    <div class="mb-6">
        <a href="{{ route('university.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-5">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Create Major</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Add a new prodi</h2>

                <form method="POST" action="{{ route('university.majors.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <input name="name" placeholder="Major name..." class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <button class="w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                        Save
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Majors</p>
                <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Your majors list</h2>

                <div class="mt-6 space-y-3">
                    @forelse ($majors as $major)
                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                            <p class="text-sm font-black text-slate-900">{{ $major->name }}</p>
                            <form method="POST" action="{{ route('university.majors.destroy', $major) }}">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 ring-1 ring-slate-200 hover:ring-rose-300">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-slate-500">No majors yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-univ-layout>

