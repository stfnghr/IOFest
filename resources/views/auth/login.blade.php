<x-guest-layout>
    <div class="min-h-screen bg-white">
        <div class="mx-auto grid min-h-screen max-w-7xl grid-cols-1 lg:grid-cols-2">
            <div class="relative hidden overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 p-12 lg:flex lg:flex-col lg:justify-between">
                <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-32 h-[520px] w-[520px] rounded-full bg-indigo-300/20 blur-3xl"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-2 text-white ring-1 ring-white/15">
                        <span class="text-sm font-black tracking-tight">UC HUB</span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-75">Platform Magang & Karir</span>
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="rounded-3xl bg-white/10 p-8 ring-1 ring-white/15 backdrop-blur">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">Hero Illustration</p>
                        <div class="mt-4 grid place-items-center rounded-2xl bg-white/10 p-10">
                            <div class="text-center">
                                <p class="text-lg font-black tracking-tight text-white">Students × Office Buildings</p>
                                <p class="mt-2 text-sm font-medium text-white/70">Modern illustration placeholder</p>
                            </div>
                        </div>
                        <h1 class="mt-8 text-5xl font-black tracking-tight text-white">
                            Satu pintu akses magang terverifikasi.
                        </h1>
                        <p class="mt-3 text-base font-medium text-indigo-50/90">
                            Login mahasiswa melalui University ID (SSO). Perusahaan memiliki portal onboarding terpisah.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center px-6 py-12 sm:px-12 lg:px-16">
                <div class="w-full max-w-md" x-data="{ tab: 'student', showPassword: false }">
                    <div class="mb-10">
                        <h2 class="text-4xl font-black tracking-tight text-slate-900">Sign in</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-500">
                            Masuk ke UC HUB sesuai tipe akun.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-1 ring-1 ring-slate-200">
                        <div class="grid grid-cols-2 gap-1">
                            <button type="button"
                                class="rounded-xl px-4 py-3 text-sm font-black"
                                :class="tab === 'student' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                @click="tab = 'student'">
                                Student Login
                            </button>
                            <button type="button"
                                class="rounded-xl px-4 py-3 text-sm font-black"
                                :class="tab === 'company' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                @click="tab = 'company'">
                                Company Login
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 space-y-6" x-show="tab === 'student'" x-cloak>
                        <a href="{{ route('google.redirect') }}"
                           class="group flex w-full items-center justify-center gap-3 rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                            <svg class="h-5 w-5 opacity-90" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3 2 9l10 6 10-6-10-6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M6 11v6c0 1.5 3 3 6 3s6-1.5 6-3v-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Login with University ID
                        </a>

                        <div class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
                            <p class="text-sm font-bold text-slate-700">SSO sedang bermasalah?</p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Gunakan registrasi manual sebagai jalur fallback, lalu akun akan diverifikasi oleh Admin Universitas.
                            </p>
                            <a href="{{ route('register') }}" class="mt-4 inline-flex rounded-xl bg-white px-4 py-2.5 text-sm font-black text-slate-700 ring-1 ring-slate-200 hover:ring-indigo-300">
                                Manual Student Register
                            </a>
                        </div>
                    </div>

                    <div class="mt-8" x-show="tab === 'company'" x-cloak>
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="login_as" value="company" />

                            <div class="space-y-1">
                                <x-input-label for="email" :value="__('Corporate Email')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800">Forgot?</a>
                                </div>

                                <div class="relative">
                                    <x-text-input id="password"
                                        class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 pr-12 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="password"
                                        x-bind:type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        required />
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600"
                                        @click="showPassword = !showPassword"
                                        :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                        <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                        <svg x-show="showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M10.6 10.6a3 3 0 0 0 4.24 4.24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M9.88 5.08A9.86 9.86 0 0 1 12 4.5c6.5 0 10 7.5 10 7.5a18.3 18.3 0 0 1-4.18 5.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M6.2 6.2C3.8 8.1 2 12 2 12s3.5 7 10 7c1.14 0 2.2-.18 3.17-.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                                Sign in as Company
                            </button>
                        </form>

                        <p class="mt-8 text-center text-xs font-black uppercase tracking-widest text-slate-400">
                            New company? <a href="{{ route('company.register') }}" class="text-indigo-600 hover:underline">Create company account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>