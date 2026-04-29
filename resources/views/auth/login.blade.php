<x-guest-layout>
    <div class="fixed inset-0 flex flex-col lg:flex-row bg-white overflow-y-auto">
        
        <div class="relative hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#4F46E5] via-[#7C3AED] to-[#EC4899] items-center justify-center p-12 overflow-hidden">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-24 -right-24 w-[500px] h-[500px] bg-indigo-300/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-center text-white max-w-lg">
                <img src="https://ouch-cdn2.icons8.com/XF9O9O4fHq-I8l8lXjO-v3q3-i7-9-I-9-I-9-I-9-I/rs:fit:456:456/czM6Ly9pY29uczgu/b3VjaC1wcm9kLmFz/c2V0cy9zdmcvMjY1/L2Y0Zjg4ZGE0LWEw/NzAtNGIyNC1iMTI3/LTBkZjg4MDNkNDM2/OC5zdmc.png" 
                     alt="UC HUB Mascot" 
                     class="w-full max-w-[400px] mx-auto drop-shadow-[0_35px_35px_rgba(0,0,0,0.3)] animate-float">
                
                <h1 class="text-6xl font-black mt-12 tracking-tighter uppercase italic">UC HUB</h1>
                <p class="text-xl font-medium text-indigo-100 mt-4 leading-relaxed">
                    Sistem Terintegrasi Magang Mahasiswa, Mitra Industri, dan Akreditasi Kampus. 
                </p>
                
                <div class="mt-10 flex flex-wrap justify-center gap-6 text-[10px] font-black uppercase tracking-[0.2em] opacity-60">
                    <span class="border-b-2 border-white/30 pb-1">Verified Student</span>
                    <span class="border-b-2 border-white/30 pb-1">Verified Company</span>
                    <span class="border-b-2 border-white/30 pb-1">BAN-PT Ready</span>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 bg-white">
            <div class="w-full max-w-md space-y-8 animate-slide-up">
                
                <div class="text-left">
                    <h2 class="text-5xl font-black text-slate-900 tracking-tighter">Sign In.</h2>
                    <p class="text-slate-500 mt-3 font-semibold text-lg leading-tight">
                        Masuk untuk akses Dashboard UC HUB Anda. [cite: 3, 22, 47]
                    </p>
                </div>

                <div class="pt-2">
                    <a href="{{ route('google.redirect') }}" 
                       class="flex items-center justify-center gap-4 w-full py-4 bg-white border-2 border-slate-100 rounded-[24px] font-black text-slate-700 shadow-sm hover:bg-slate-50 hover:border-indigo-200 hover:shadow-lg transition-all duration-300 transform active:scale-[0.97]">
                        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="h-6 w-6">
                        <span>Lanjut dengan Akun Google</span>
                    </a>
                </div>

                <div class="relative flex py-4 items-center">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink mx-4 text-slate-300 text-[10px] font-black uppercase tracking-widest">Portal Login</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-1">
                        <x-input-label for="email" :value="__('EMAIL PORTAL')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                        <x-text-input id="email" class="block w-full px-6 py-4 bg-slate-50 border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 transition-all" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <x-input-label for="password" :value="__('PASSWORD')" class="text-[10px] font-black text-slate-400 tracking-[0.1em]" />
                            <a href="{{ route('password.request') }}" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lupa?</a>
                        </div>
                        <x-text-input id="password" class="block w-full px-6 py-4 bg-slate-50 border-none focus:ring-4 focus:ring-indigo-500/10 rounded-[20px] font-medium text-slate-700 transition-all" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[24px] font-black text-lg shadow-2xl shadow-slate-300 hover:bg-indigo-600 hover:shadow-indigo-200 transition-all duration-300 transform active:scale-[0.97]">
                            MASUK SEKARANG
                        </button>
                    </div>
                </form>

                <p class="text-center mt-12 text-sm font-bold text-slate-400 uppercase tracking-widest">
                    Belum Terdaftar? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Buat Akun UC HUB</a> [cite: 73]
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-slide-up { animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1); }
        /* Menghilangkan scrollbar tapi tetap bisa scroll */
        .overflow-y-auto::-webkit-scrollbar { display: none; }
    </style>
</x-guest-layout>