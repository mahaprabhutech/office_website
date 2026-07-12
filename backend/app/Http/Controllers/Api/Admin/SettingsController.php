<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return SiteSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');
    }

    public function update(Request $request)
    {
        $data = $request->validate(['settings' => ['required','array']]);

        foreach ($data['settings'] as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'type' => is_array($value) ? 'json' : 'text',
                    'group' => 'public',
                ]
            );
        }

        return response()->json(['message' => 'Settings updated successfully.']);
    }
}
