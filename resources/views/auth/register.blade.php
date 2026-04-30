<x-guest-layout>
    <div class="min-h-screen bg-white">
        <div class="mx-auto grid min-h-screen max-w-7xl grid-cols-1 lg:grid-cols-2">
            <div class="relative hidden overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 p-12 lg:flex lg:flex-col lg:justify-between">
                <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-32 h-[520px] w-[520px] rounded-full bg-indigo-300/20 blur-3xl"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-2 text-white ring-1 ring-white/15">
                        <span class="text-sm font-black tracking-tight">UC HUB</span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-75">Manual Student Register</span>
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="rounded-3xl bg-white/10 p-8 ring-1 ring-white/15 backdrop-blur">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">SSO Fallback</p>
                        <h1 class="mt-4 text-4xl font-black tracking-tight text-white">
                            Registrasi manual saat SSO kampus down.
                        </h1>
                        <p class="mt-3 text-base font-medium text-indigo-50/90">
                            Upload KTM diperlukan sebagai bukti identitas. Akun akan berstatus <span class="font-black">Pending Validation</span>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-slate-50 px-6 py-12 sm:px-12 lg:px-16">
                <div class="w-full max-w-2xl rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200" x-data="{ showPassword: false, showPasswordConfirm: false }">
                    <div class="mb-8">
                        <h2 class="text-3xl font-black tracking-tight text-slate-900">Student Register (Fallback)</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-500">
                            Gunakan email kampus (domain harus terdaftar).
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-1">
                                <x-input-label for="name" :value="__('Full Name')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="name" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="space-y-1">
                                <x-input-label for="email" :value="__('University Email')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-1">
                                <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <div class="relative">
                                    <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 pr-12 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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

                            <div class="space-y-1">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <div class="relative">
                                    <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 pr-12 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="password"
                                        x-bind:type="showPasswordConfirm ? 'text' : 'password'"
                                        name="password_confirmation"
                                        required />
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600"
                                        @click="showPasswordConfirm = !showPasswordConfirm"
                                        :aria-label="showPasswordConfirm ? 'Hide password' : 'Show password'">
                                        <svg x-show="!showPasswordConfirm" class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                        <svg x-show="showPasswordConfirm" class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M10.6 10.6a3 3 0 0 0 4.24 4.24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M9.88 5.08A9.86 9.86 0 0 1 12 4.5c6.5 0 10 7.5 10 7.5a18.3 18.3 0 0 1-4.18 5.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M6.2 6.2C3.8 8.1 2 12 2 12s3.5 7 10 7c1.14 0 2.2-.18 3.17-.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-1">
                                <x-input-label for="nim" :value="__('NIM')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="nim" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="nim" :value="old('nim')" required />
                                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                            </div>
                            <div class="space-y-1">
                                <x-input-label for="semester" :value="__('Semester')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="semester" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="number" name="semester" :value="old('semester')" required min="1" />
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-1">
                                <x-input-label for="faculty" :value="__('Faculty')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="faculty" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="faculty" :value="old('faculty')" required />
                                <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
                            </div>
                            <div class="space-y-1">
                                <x-input-label for="major" :value="__('Major')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                                <x-text-input id="major" class="block w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="major" :value="old('major')" required />
                                <x-input-error :messages="$errors->get('major')" class="mt-2" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-input-label for="ktm" :value="__('Upload Foto KTM (Bukti Identitas)')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <input id="ktm" name="ktm" type="file" accept="image/*"
                                class="block w-full rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm file:mr-4 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-black file:text-white hover:file:bg-indigo-600"
                                required />
                            <x-input-error :messages="$errors->get('ktm')" class="mt-2" />
                            <p class="mt-2 text-xs font-semibold text-slate-400">Maks 5MB. Format JPG/PNG.</p>
                        </div>

                        <button type="submit" class="w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                            Create Student Account
                        </button>

                        <p class="text-center text-xs font-black uppercase tracking-widest text-slate-400">
                            Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>