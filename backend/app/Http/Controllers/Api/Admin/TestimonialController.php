<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() { return Testimonial::orderBy('sort_order')->paginate(30); }
    public function store(Request $request) { return response()->json(Testimonial::create($this->validated($request)), 201); }
    public function show(Testimonial $testimonial) { return $testimonial; }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validated($request));
        return $testimonial->fresh();
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->noContent();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required','string','max:120'],
            'organisation' => ['nullable','string','max:150'],
            'designation' => ['nullable','string','max:120'],
            'photo' => ['nullable','string','max:500'],
            'review' => ['required','string','max:2000'],
            'rating' => ['integer','min:1','max:5'],
            'active' => ['boolean'],
            'sort_order' => ['integer','min:0'],
        ]);
    }
}
