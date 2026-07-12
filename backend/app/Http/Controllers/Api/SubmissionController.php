<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Quotation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function contact(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:150'],
            'mobile' => ['required','string','max:20'],
            'company' => ['nullable','string','max:150'],
            'service' => ['nullable','string','max:150'],
            'budget_range' => ['nullable','string','max:100'],
            'message' => ['required','string','max:5000'],
            'attachment' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,png','max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('enquiries', 'public');
        }

        $data['status'] = 'new';
        $enquiry = Enquiry::create($data);

        return response()->json([
            'message' => 'Thank you. Your enquiry has been received.',
            'reference' => 'ENQ-'.str_pad((string) $enquiry->id, 6, '0', STR_PAD_LEFT),
        ], 201);
    }

    public function quotation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'company' => ['nullable','string','max:150'],
            'email' => ['required','email'],
            'mobile' => ['required','string','max:20'],
            'project_type' => ['required','string','max:150'],
            'platforms' => ['nullable','array'],
            'description' => ['required','string','max:10000'],
            'budget' => ['nullable','string','max:100'],
            'expected_date' => ['nullable','date'],
            'contact_method' => ['nullable','string','max:50'],
            'attachment' => ['nullable','file','mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png','max:10240'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('quotations', 'public');
        }

        $data['status'] = 'received';
        $quotation = Quotation::create($data);

        return response()->json([
            'message' => 'Quotation request submitted.',
            'reference' => 'QTN-'.str_pad((string) $quotation->id, 6, '0', STR_PAD_LEFT),
        ], 201);
    }

    public function jobApplication(Request $request, Job $job): JsonResponse
    {
        abort_unless($job->active, 404);

        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email'],
            'mobile' => ['required','string','max:20'],
            'location' => ['nullable','string','max:150'],
            'qualification' => ['required','string','max:250'],
            'experience' => ['nullable','string','max:250'],
            'skills' => ['nullable','string','max:1000'],
            'portfolio_url' => ['nullable','url','max:500'],
            'cover_letter' => ['nullable','string','max:5000'],
            'resume' => ['required','file','mimes:pdf,doc,docx','max:5120'],
        ]);

        $data['job_id'] = $job->id;
        $data['resume'] = $request->file('resume')->store('resumes', 'local');
        $data['status'] = 'received';
        JobApplication::create($data);

        return response()->json(['message' => 'Your application has been submitted successfully.'], 201);
    }
}
