<x-company-layout title="Create Job">
    <div class="mb-6">
        <a href="{{ route('company.jobs.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm hover:bg-slate-200">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('company.jobs.store') }}" class="space-y-6">
        @csrf

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-black text-slate-900">1) Job Details</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <input name="title" value="{{ old('title') }}" placeholder="Job Title" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500" />
                <input name="category" value="{{ old('category') }}" placeholder="Category" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500" />
                <input name="duration" value="{{ old('duration') }}" placeholder="Duration (e.g., 6 months)" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500" />
                <select name="work_type" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500">
                    <option value="remote">Remote</option>
                    <option value="hybrid" selected>Hybrid</option>
                    <option value="on-site">On-site</option>
                </select>
                <select name="status" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500">
                    <option value="active">Active</option>
                    <option value="hidden">Hidden</option>
                    <option value="closed">Closed</option>
                </select>
                <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_paid" value="1" class="rounded border-slate-300 text-violet-700">
                    Paid internship
                </label>
            </div>
            <textarea name="description" rows="6" placeholder="Job description..." class="mt-4 w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500">{{ old('description') }}</textarea>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-black text-slate-900">2) Requirements (Skills)</h2>
            <div class="mt-4 grid grid-cols-1 gap-2 md:grid-cols-2">
                @foreach ($skills as $skill)
                    <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold">
                        <input type="checkbox" name="skill_ids[]" value="{{ $skill->id }}" class="rounded border-slate-300 text-violet-700">
                        {{ $skill->name }} <span class="text-xs text-slate-400">({{ $skill->category }})</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-black text-slate-900">3) Target Campuses (Verified Partnerships Only)</h2>
            <div class="mt-4 grid grid-cols-1 gap-2 md:grid-cols-2">
                @forelse ($targetUniversities as $university)
                    <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold">
                        <input type="checkbox" name="target_university_ids[]" value="{{ $university->id }}" class="rounded border-slate-300 text-violet-700">
                        {{ $university->name }}
                    </label>
                @empty
                    <p class="text-sm font-semibold text-amber-700">Belum ada partnership verified. Ajukan kerja sama dulu di halaman Partnerships.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200" x-data="{ questions: [{ question: '', is_required: false }] }">
            <h2 class="text-lg font-black text-slate-900">4) Custom Questions</h2>
            <template x-for="(row, index) in questions" :key="index">
                <div class="mt-4 rounded-xl border border-slate-200 p-4">
                    <input :name="`custom_questions[${index}][question]`" x-model="row.question" placeholder="Question..." class="w-full rounded-xl border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 focus:border-violet-500 focus:ring-violet-500" />
                    <label class="mt-2 inline-flex items-center gap-2 text-sm font-semibold">
                        <input type="checkbox" :name="`custom_questions[${index}][is_required]`" value="1" x-model="row.is_required" class="rounded border-slate-300 text-violet-700">
                        Required
                    </label>
                </div>
            </template>
            <button type="button" @click="questions.push({ question: '', is_required: false })" class="mt-4 rounded-xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-700 hover:bg-slate-200">
                + Add Question
            </button>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('company.jobs.index') }}" class="rounded-xl bg-slate-100 px-5 py-3 text-xs font-black text-slate-700 shadow-sm hover:bg-slate-200">← Kembali</a>
            <button class="rounded-xl bg-violet-600 px-5 py-3 text-xs font-black text-white shadow-sm hover:bg-violet-700">Publish Job</button>
        </div>
    </form>
</x-company-layout>

