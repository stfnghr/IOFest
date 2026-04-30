<x-student-layout title="Profile & CV Builder">
    @if (session('status'))
        <div class="mb-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-700">{{ session('status') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12"
        x-data="{
            name: @js($student->name),
            nim: @js($student->studentProfile?->nim ?? ''),
            faculty: @js($student->studentProfile?->faculty ?? ''),
            major: @js($student->studentProfile?->major ?? ''),
            semester: @js((string) ($student->studentProfile?->semester ?? '')),
            workPreference: @js($student->userPreference?->work_preference ?? 'hybrid'),
            interestCategories: @js($student->userPreference?->interest_categories ?? []),
            selectedSkillIds: @js($student->skills->pluck('id')->values()),
            selectedSkillLabels: @js($student->skills->pluck('name')->values()),
            addInterest(cat) {
                if (!this.interestCategories.includes(cat)) this.interestCategories.push(cat);
            },
            removeInterest(cat) {
                this.interestCategories = this.interestCategories.filter(c => c !== cat);
            }
        }">

        <div class="lg:col-span-6">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">CV Builder</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Build your digital profile</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Form ini akan menggerakkan preview CV secara real-time.</p>
                    </div>
                    <span class="inline-flex items-center rounded-2xl bg-indigo-50 px-4 py-2 text-xs font-black text-indigo-700 ring-1 ring-indigo-100">
                        Live Preview
                    </span>
                </div>

                <form method="POST" action="{{ route('student.profile.update') }}" class="mt-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Full Name</p>
                            <input disabled value="{{ $student->name }}"
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm" />
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">NIM</p>
                            <input name="nim" x-model="nim" value="{{ old('nim', $student->studentProfile?->nim) }}"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('nim') <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Faculty</p>
                            <input name="faculty" x-model="faculty" value="{{ old('faculty', $student->studentProfile?->faculty) }}"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('faculty') <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Major</p>
                            <input name="major" x-model="major" value="{{ old('major', $student->studentProfile?->major) }}"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('major') <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Semester</p>
                            <input type="number" min="1" name="semester" x-model="semester" value="{{ old('semester', $student->studentProfile?->semester) }}"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('semester') <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Work Preference</p>
                            <select name="work_preference" x-model="workPreference"
                                class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="on-site">On-site</option>
                            </select>
                            @error('work_preference') <p class="mt-2 text-sm font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Interest Categories</p>
                            <p class="text-xs font-bold text-slate-400">Pick at least 3</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @foreach (['Frontend', 'Backend', 'Data', 'UI/UX', 'Product', 'HR', 'Marketing', 'Software', 'Business'] as $chip)
                                <button type="button"
                                    class="rounded-full px-3 py-2 text-xs font-black ring-1"
                                    :class="interestCategories.includes('{{ $chip }}') ? 'bg-indigo-50 text-indigo-700 ring-indigo-100' : 'bg-white text-slate-600 ring-slate-200 hover:ring-indigo-300'"
                                    @click="interestCategories.includes('{{ $chip }}') ? removeInterest('{{ $chip }}') : addInterest('{{ $chip }}')">
                                    {{ $chip }}
                                </button>
                            @endforeach
                        </div>

                        <template x-for="cat in interestCategories" :key="cat">
                            <input type="hidden" name="interest_categories[]" :value="cat" />
                        </template>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">Skills</p>
                            <p class="text-xs font-bold text-slate-400">Select multiple</p>
                        </div>

                        <select multiple
                            class="w-full rounded-2xl border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            @change="
                                selectedSkillIds = Array.from($event.target.selectedOptions).map(o => parseInt(o.value));
                                selectedSkillLabels = Array.from($event.target.selectedOptions).map(o => o.dataset.label);
                            ">
                            @foreach ($allSkills as $skill)
                                <option value="{{ $skill->id }}" data-label="{{ $skill->name }}" @selected($student->skills->pluck('id')->contains($skill->id))>
                                    {{ $skill->category }} — {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>

                        <template x-for="id in selectedSkillIds" :key="id">
                            <input type="hidden" name="skill_ids[]" :value="id" />
                        </template>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="label in selectedSkillLabels" :key="label">
                                <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1.5 text-xs font-black text-slate-700 ring-1 ring-slate-200" x-text="label"></span>
                            </template>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button class="w-full rounded-2xl bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-sm hover:bg-indigo-600">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-6">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Live Resume Preview</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Preview A4 (virtual paper).</p>

                <div class="mt-6 flex justify-center">
                    <div class="w-full max-w-[520px] rounded-2xl bg-slate-100 p-4">
                        <div class="aspect-[1/1.414] w-full rounded-xl bg-white p-10 shadow-sm ring-1 ring-slate-200">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <h3 class="truncate text-2xl font-black tracking-tight text-slate-900" x-text="name"></h3>
                                    <p class="mt-1 text-sm font-semibold text-slate-500">
                                        <span x-text="major"></span>
                                        <span class="text-slate-300">•</span>
                                        <span x-text="faculty"></span>
                                    </p>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-indigo-700 ring-1 ring-indigo-100">
                                    Student
                                </span>
                            </div>

                            <div class="mt-8 grid grid-cols-2 gap-6 text-sm">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">NIM</p>
                                    <p class="mt-1 font-bold text-slate-700" x-text="nim || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Semester</p>
                                    <p class="mt-1 font-bold text-slate-700" x-text="semester || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Work Preference</p>
                                    <p class="mt-1 font-bold text-slate-700" x-text="workPreference"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Interests</p>
                                    <p class="mt-1 font-bold text-slate-700" x-text="interestCategories.slice(0,3).join(', ') || '-'"></p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Skills</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <template x-for="label in selectedSkillLabels.slice(0, 10)" :key="label">
                                        <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1.5 text-xs font-black text-slate-700 ring-1 ring-slate-200" x-text="label"></span>
                                    </template>
                                    <template x-if="selectedSkillLabels.length === 0">
                                        <span class="text-sm font-semibold text-slate-400">No skills selected yet.</span>
                                    </template>
                                </div>
                            </div>

                            <div class="mt-10 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Tip</p>
                                <p class="mt-2 text-sm font-semibold text-slate-600">
                                    CV ATS-ready akan digenerate di fase berikutnya. Untuk sekarang, fokus isi data agar matching akurat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>

