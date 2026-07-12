<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index() { return TeamMember::orderBy('sort_order')->paginate(30); }
    public function store(Request $request) { return response()->json(TeamMember::create($this->validated($request)), 201); }
    public function show(TeamMember $teamMember) { return $teamMember; }

    public function update(Request $request, TeamMember $teamMember)
    {
        $teamMember->update($this->validated($request));
        return $teamMember->fresh();
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return response()->noContent();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required','string','max:120'],
            'designation' => ['required','string','max:120'],
            'department' => ['nullable','string','max:120'],
            'bio' => ['nullable','string'],
            'photo' => ['nullable','string','max:500'],
            'skills' => ['nullable','array'],
            'linkedin_url' => ['nullable','url','max:500'],
            'email' => ['nullable','email','max:150'],
            'active' => ['boolean'],
            'sort_order' => ['integer','min:0'],
        ]);
    }
}
