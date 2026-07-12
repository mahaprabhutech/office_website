<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        return response()->json(Project::create($data), 201);
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
        return $request->validate([
            'title' => ['required','string','max:180'],
            'slug' => ['nullable','string','max:190','unique:projects,slug,'.($id ?? 'NULL')],
            'category' => ['required','string','max:120'],
            'summary' => ['required','string','max:700'],
            'description' => ['required','string'],
            'cover_image' => ['nullable','string','max:500'],
            'features' => ['nullable','array'],
            'technologies' => ['nullable','array'],
            'project_status' => ['required','string','max:60'],
            'website_url' => ['nullable','url','max:500'],
            'android_url' => ['nullable','url','max:500'],
            'ios_url' => ['nullable','url','max:500'],
            'brochure' => ['nullable','string','max:500'],
            'featured' => ['boolean'],
            'active' => ['boolean'],
            'sort_order' => ['integer','min:0'],
        ]);
    }
}
