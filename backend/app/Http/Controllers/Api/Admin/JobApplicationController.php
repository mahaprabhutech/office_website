<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('job:id,title');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%"));
        }

        return $query->latest()->paginate(30);
    }

    public function show(JobApplication $jobApplication)
    {
        return $jobApplication->load('job:id,title');
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $jobApplication->update($request->validate([
            'status' => ['sometimes', 'in:received,shortlisted,interview,selected,rejected'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]));

        return $jobApplication->fresh('job:id,title');
    }

    public function resume(JobApplication $jobApplication)
    {
        abort_unless(Storage::disk('local')->exists($jobApplication->resume), 404, 'Resume file not found.');

        return Storage::disk('local')->download($jobApplication->resume);
    }
}
