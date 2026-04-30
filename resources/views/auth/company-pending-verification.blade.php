<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white p-10 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 ring-1 ring-amber-100">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 9v4l2.5 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900">Pending Verification</h1>
                        <p class="mt-2 text-sm font-medium text-slate-500">
                            Terima kasih. Akun perusahaan kamu sudah dibuat dengan status <span class="font-black text-slate-700">Unverified</span>.
                            Silakan cek email untuk instruksi verifikasi.
                        </p>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl bg-slate-50 p-6">
                    <p class="text-sm font-bold text-slate-700">Yang akan terjadi selanjutnya</p>
                    <ul class="mt-4 space-y-3 text-sm font-medium text-slate-600">
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-xs font-black text-slate-700 ring-1 ring-slate-200">1</span>
                            Kami akan mengirim email verifikasi akun.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-xs font-black text-slate-700 ring-1 ring-slate-200">2</span>
                            Setelah terverifikasi, kamu bisa melengkapi profil & legalitas perusahaan.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-xs font-black text-slate-700 ring-1 ring-slate-200">3</span>
                            Admin Universitas akan memproses kerja sama (MoU) sebelum lowongan tampil ke mahasiswa.
                        </li>
                    </ul>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

