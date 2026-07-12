<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Job;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    public function home(): JsonResponse
    {
        return response()->json([
            'services' => Service::where('active', true)->where('featured', true)->orderBy('sort_order')->take(6)->get(),
            'projects' => Project::where('active', true)->where('featured', true)->orderBy('sort_order')->take(6)->get(),
            'testimonials' => Testimonial::where('active', true)->orderBy('sort_order')->take(6)->get(),
            'posts' => BlogPost::where('status', 'published')->latest('published_at')->take(3)->get(),
            'settings' => SiteSetting::where('group', 'public')->pluck('value', 'key')->all(),
        ]);
    }

    public function services(): JsonResponse
    {
        return response()->json(Service::where('active', true)->orderBy('sort_order')->paginate(12));
    }

    public function service(Service $service): JsonResponse
    {
        abort_unless($service->active, 404);
        return response()->json($service);
    }

    public function projects(): JsonResponse
    {
        return response()->json(Project::where('active', true)->orderBy('sort_order')->paginate(12));
    }

    public function project(Project $project): JsonResponse
    {
        abort_unless($project->active, 404);
        return response()->json($project->load('images'));
    }

    public function team(): JsonResponse
    {
        return response()->json(TeamMember::where('active', true)->orderBy('sort_order')->get());
    }

    public function jobs(): JsonResponse
    {
        return response()->json(
            Job::where('active', true)
                ->where(fn ($query) => $query->whereNull('deadline')->orWhereDate('deadline', '>=', today()))
                ->latest()
                ->get()
        );
    }

    public function job(Job $job): JsonResponse
    {
        abort_unless($job->active, 404);
        return response()->json($job);
    }

    public function posts(): JsonResponse
    {
        return response()->json(BlogPost::where('status', 'published')->latest('published_at')->paginate(10));
    }

    public function post(BlogPost $blogPost): JsonResponse
    {
        abort_unless($blogPost->status === 'published', 404);
        return response()->json($blogPost->load('author:id,name'));
    }

    public function settings(): JsonResponse
    {
        return response()->json(SiteSetting::where('group', 'public')->pluck('value', 'key')->all());
    }
}
