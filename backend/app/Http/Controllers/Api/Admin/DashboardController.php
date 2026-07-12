<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'metrics' => [
                'services' => Service::count(),
                'projects' => Project::count(),
                'new_enquiries' => Enquiry::where('status', 'new')->count(),
                'quotations' => Quotation::count(),
                'job_applications' => JobApplication::count(),
                'published_posts' => BlogPost::where('status', 'published')->count(),
            ],
            'recent_enquiries' => Enquiry::latest()->take(8)->get(),
            'recent_quotations' => Quotation::latest()->take(5)->get(),
        ]);
    }
}
