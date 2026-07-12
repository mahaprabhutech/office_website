<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index() { return Job::withCount('applications')->latest()->paginate(20); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']).'-'.Str::lower(Str::random(4));
        return response()->json(Job::create($data), 201);
    }

    public function show(Job $job) { return $job->load('applications'); }

    public function update(Request $request, Job $job)
    {
        $job->update($this->validated($request, $job->id));
        return $job->fresh();
    }

    public function destroy(Job $job)
    {
        abort_if($job->applications()->exists(), 422, 'A job with applications cannot be deleted. Deactivate it instead.');
        $job->delete();
        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required','string','max:160'],
            'slug' => ['nullable','string','max:180','unique:jobs,slug,'.($id ?? 'NULL')],
            'department' => ['required','string','max:100'],
            'employment_type' => ['required','string','max:60'],
            'location' => ['required','string','max:160'],
            'experience' => ['nullable','string','max:160'],
            'qualification' => ['required','string','max:300'],
            'skills' => ['nullable','array'],
            'responsibilities' => ['nullable','array'],
            'description' => ['required','string'],
            'salary_range' => ['nullable','string','max:120'],
            'openings' => ['integer','min:1'],
            'deadline' => ['nullable','date'],
            'active' => ['boolean'],
        ]);
    }
}
