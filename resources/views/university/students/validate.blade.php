<x-univ-layout title="Student Validation">
    <div class="mb-6">
        <a href="{{ route('university.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm ring-1 ring-slate-200 hover:ring-indigo-300">
            ← Kembali
        </a>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Manual Fallback</p>
        <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Pending validation queue</h2>
        <p class="mt-2 text-sm font-semibold text-slate-500">Verifikasi mahasiswa yang daftar via registrasi manual (SSO fallback).</p>

        <div class="mt-6 space-y-6">
            @forelse ($pending as $profile)
                @php
                    $ktmUrl = \App\Http\Controllers\University\StudentValidationController::ktmUrl($profile->ktm_path);
                @endphp
                <div class="grid grid-cols-1 gap-6 rounded-3xl bg-slate-50 p-6 ring-1 ring-slate-200 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                            @if ($ktmUrl)
                                <img src="{{ $ktmUrl }}" alt="KTM" class="h-72 w-full object-cover" />
                            @else
                                <div class="grid h-72 place-items-center">
                                    <p class="text-sm font-semibold text-slate-500">No KTM uploaded.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="lg:col-span-7">
                        <p class="text-sm font-black text-slate-900">{{ $profile->user->name }}</p>
                        <p class="mt-1 text-sm font-semibold text-slate-500">{{ $profile->user->email }}</p>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">NIM</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $profile->nim }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Semester</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $profile->semester }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Faculty</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $profile->faculty }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Major</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $profile->major }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('university.students.verify', $profile) }}">
                                @csrf
                                <button class="rounded-2xl bg-slate-900 px-6 py-3 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                                    Verify
                                </button>
                            </form>
                            <form method="POST" action="{{ route('university.students.reject', $profile) }}">
                                @csrf
                                <button class="rounded-2xl bg-white px-6 py-3 text-xs font-black text-slate-700 ring-1 ring-slate-200 hover:ring-rose-300">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-slate-50 p-10 text-center ring-1 ring-slate-200">
                    <p class="text-sm font-semibold text-slate-500">No students pending validation.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-univ-layout>

