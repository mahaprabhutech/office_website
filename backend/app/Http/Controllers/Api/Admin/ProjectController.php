<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('images')->orderBy('sort_order')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        return response()->json(Project::create($data)->load('images'), 201);
    }

    public function show(Project $project)
    {
        return $project->load('images');
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request, $project->id);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $project->update($data);

        return $project->fresh('images');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $slugRule = Rule::unique('projects', 'slug');
        if ($id !== null) {
            $slugRule->ignore($id);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:190',
                $slugRule,
            ],
            'category' => ['required', 'string', 'max:120'],
            'product_type' => ['nullable', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:320'],
            'summary' => ['required', 'string', 'max:700'],
            'description' => ['required', 'string'],
            'problem_statement' => ['nullable', 'string'],
            'solution_overview' => ['nullable', 'string'],
            'project_plan' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'logo_image' => ['nullable', 'string', 'max:500'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:500'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['string', 'max:120'],
            'audiences' => ['nullable', 'array'],
            'audiences.*' => ['string', 'max:300'],
            'workflow' => ['nullable', 'array'],
            'workflow.*' => ['string', 'max:500'],
            'roadmap' => ['nullable', 'array'],
            'roadmap.*' => ['string', 'max:500'],
            'security_features' => ['nullable', 'array'],
            'security_features.*' => ['string', 'max:500'],
            'impact_points' => ['nullable', 'array'],
            'impact_points.*' => ['string', 'max:500'],
            'project_status' => ['required', 'string', 'max:60'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'android_url' => ['nullable', 'url', 'max:500'],
            'ios_url' => ['nullable', 'url', 'max:500'],
            'brochure' => ['nullable', 'string', 'max:500'],
            'featured' => ['boolean'],
            'active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ]);
    }
}
