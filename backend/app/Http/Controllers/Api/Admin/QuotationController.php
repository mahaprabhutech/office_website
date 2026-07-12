<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        return $query->latest()->paginate(30);
    }

    public function show(Quotation $quotation) { return $quotation; }

    public function update(Request $request, Quotation $quotation)
    {
        $quotation->update($request->validate([
            'status' => ['sometimes','in:received,reviewing,proposal_sent,accepted,rejected,closed'],
            'estimated_amount' => ['nullable','numeric','min:0'],
            'proposal' => ['nullable','string','max:500'],
            'internal_notes' => ['nullable','string','max:5000'],
        ]));

        return $quotation->fresh();
    }
}
