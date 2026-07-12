<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index() { return BlogPost::with('author:id,name')->latest()->paginate(20); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        return response()->json(BlogPost::create($data), 201);
    }

    public function show(BlogPost $blogPost) { return $blogPost->load('author:id,name'); }

    public function update(Request $request, BlogPost $blogPost)
    {
        $blogPost->update($this->validated($request, $blogPost->id));
        return $blogPost->fresh();
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required','string','max:180'],
            'slug' => ['nullable','string','max:190','unique:blog_posts,slug,'.($id ?? 'NULL')],
            'category' => ['required','string','max:100'],
            'excerpt' => ['required','string','max:700'],
            'content' => ['required','string'],
            'featured_image' => ['nullable','string','max:500'],
            'tags' => ['nullable','array'],
            'status' => ['required','in:draft,published'],
            'published_at' => ['nullable','date'],
            'seo_title' => ['nullable','string','max:180'],
            'seo_description' => ['nullable','string','max:300'],
        ]);
    }
}
