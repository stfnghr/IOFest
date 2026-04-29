<x-guest-layout>
    <div class="fixed inset-0 flex flex-col lg:flex-row bg-white overflow-y-auto">
        
        <div class="relative hidden lg:flex lg:w-[40%] bg-gradient-to-tr from-[#7C3AED] via-[#4F46E5] to-[#3B82F6] items-center justify-center p-12 overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-purple-300/20 rounded-full blur-[100px]"></div>

            <div class="relative z-10 text-center text-white max-w-sm">
                <img src="https://ouch-cdn2.icons8.com/6Xz_qM8G5B-5i5T-5i5T-5i5T-5i5T-5i5T-5i5T-5i5T/rs:fit:456:456/czM6Ly9pY29uczgu/b3VjaC1wcm9kLmFz/c2V0cy9zdmcvNzQz/L2Y0Zjg4ZGE0LWEw/NzAtNGIyNC1iMTI3/LTBkZjg4MDNkNDM2/OC5zdmc.png" 
                     alt="UC HUB Register Mascot" 
                     class="w-full max-w-[320px] mx-auto drop-shadow-[0_35px_35px_rgba(0,0,0,0.4)] animate-float">
                
                <h1 class="text-5xl font-black mt-10 tracking-tighter uppercase italic">UC HUB</h1>
                <p class="text-lg font-medium text-indigo-100 mt-4 leading-relaxed opacity-90">
                    Mulai perjalanan karier profesional Anda hari ini di ekosistem digital kampus.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-[60%] flex items-center justify-center p-6 sm:p-12 lg:p-20 bg-[#F9FAFB]">
            <div class="w-full max-w-2xl space-y-10 animate-slide-up">
                
                <div class="text-left">
                    <h2 class="text-5xl font-black text-slate-900 tracking-tighter">Create Account.</h2>
                    <p class="text-slate-500 mt-3 font-semibold text-lg">Pilih tipe akun dan lengkapi data diri Anda.</p>
                </div>

                <div class="pt-2">
                    <a href="{{ route('google.redirect') }}" 
                       class="flex items-center justify-center gap-4 w-full py-4 bg-white border-2 border-slate-200 rounded-[24px] font-black text-slate-700 shadow-sm hover:bg-slate-50 hover:border-indigo-200 hover:shadow-lg transition-all duration-300 transform active:scale-[0.98]">
                        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="h-6 w-6">
                        <span>Daftar Cepat dengan Google</span>
                    </a>
                </div>

                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-slate-300 text-[10px] font-black uppercase tracking-widest text-center">Atau isi data secara manual</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <x-input-label for="name" :value="__('NAMA LENGKAP')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <x-text-input id="name" class="block w-full px-6 py-4 bg-white border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="email" :value="__('EMAIL AKTIF')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <x-text-input id="email" class="block w-full px-6 py-4 bg-white border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 shadow-sm" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <x-input-label for="password" :value="__('PASSWORD')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <x-text-input id="password" class="block w-full px-6 py-4 bg-white border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 shadow-sm" type="password" name="password" required />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="password_confirmation" :value="__('KONFIRMASI PASSWORD')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <x-text-input id="password_confirmation" class="block w-full px-6 py-4 bg-white border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 shadow-sm" type="password" name="password_confirmation" required />
                        </div>
                    </div>

                    <div class="pt-6 flex flex-col items-center gap-6">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[24px] font-black text-lg shadow-2xl shadow-slate-300 hover:bg-indigo-600 hover:shadow-indigo-200 transition-all duration-300 transform active:scale-[0.97]">
                            DAFTAR AKUN SEKARANG
                        </button>
                        
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                            Sudah Terdaftar? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk ke Portal</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-15px) rotate(-1deg); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 7s ease-in-out infinite; }
        .animate-slide-up { animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .overflow-y-auto::-webkit-scrollbar { display: none; }
    </style>
</x-guest-layout>