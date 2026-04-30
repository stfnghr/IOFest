<x-univ-layout title="Dashboard">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Total Mahasiswa Aktif</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $totalStudents }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Mahasiswa terdaftar di universitas ini.</p>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Perusahaan Mitra (Verified)</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $verifiedPartners }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Mitra aktif dengan MoU valid.</p>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Total Lowongan Tersedia</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $totalJobs }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Lowongan aktif yang menarget kampus.</p>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Recent Activity</p>
                        <h2 class="mt-2 text-xl font-black tracking-tight text-slate-900">Latest requests & registrations</h2>
                    </div>
                    <a href="{{ route('university.partnerships.index') }}" class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2.5 text-xs font-black text-white shadow-sm hover:bg-indigo-600">
                        Open partnerships
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Incoming partnership requests</p>
                        <div class="mt-4 space-y-3">
                            @forelse ($recentPartnershipRequests as $company)
                                <div class="rounded-2xl bg-white p-4 ring-1 ring-slate-200">
                                    <p class="text-sm font-black text-slate-900">{{ $company->name }}</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-500">{{ $company->email }}</p>
                                </div>
                            @empty
                                <p class="text-sm font-semibold text-slate-500">No incoming requests.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Latest student registrations</p>
                        <div class="mt-4 space-y-3">
                            @forelse ($recentStudentRegistrations as $student)
                                <div class="rounded-2xl bg-white p-4 ring-1 ring-slate-200">
                                    <p class="text-sm font-black text-slate-900">{{ $student->name }}</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-500">{{ $student->email }}</p>
                                </div>
                            @empty
                                <p class="text-sm font-semibold text-slate-500">No recent registrations.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Quick Actions</p>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('university.students.validate') }}" class="inline-flex w-full justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                        Student Validation Queue
                    </a>
                    <a href="{{ route('university.analytics.index') }}" class="inline-flex w-full justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">
                        View Analytics
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-univ-layout>

