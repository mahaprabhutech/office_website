<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::with('assignee:id,name');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%"));
        }

        return $query->latest()->paginate(30);
    }

    public function show(Enquiry $enquiry) { return $enquiry->load('assignee:id,name'); }

    public function update(Request $request, Enquiry $enquiry)
    {
        $enquiry->update($request->validate([
            'status' => ['sometimes','in:new,contacted,qualified,converted,closed'],
            'assigned_to' => ['nullable','exists:users,id'],
            'follow_up_at' => ['nullable','date'],
            'internal_notes' => ['nullable','string','max:5000'],
        ]));

        return $enquiry->fresh('assignee:id,name');
    }
}
