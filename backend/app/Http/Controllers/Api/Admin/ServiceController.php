<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::orderBy('sort_order')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        return response()->json(Service::create($data), 201);
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request, $service->id);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $service->update($data);

        return $service->fresh();
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required','string','max:150'],
            'slug' => ['nullable','string','max:170','unique:services,slug,'.($id ?? 'NULL')],
            'summary' => ['required','string','max:500'],
            'description' => ['required','string'],
            'icon' => ['nullable','string','max:100'],
            'image' => ['nullable','string','max:500'],
            'benefits' => ['nullable','array'],
            'process' => ['nullable','array'],
            'featured' => ['boolean'],
            'active' => ['boolean'],
            'sort_order' => ['integer','min:0'],
            'seo_title' => ['nullable','string','max:180'],
            'seo_description' => ['nullable','string','max:300'],
        ]);
    }
}
