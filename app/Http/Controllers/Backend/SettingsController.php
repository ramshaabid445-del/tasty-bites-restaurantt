<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function generalInfo()
    {
        // Saari settings ko key-value pair mein utha lo
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('backend.management.settings.general', compact('settings'));
    }

    public function update(Request $request)
    {
        // Sab data uthao siwaye token aur logo ke
        $data = $request->except(['_token', 'restaurant_logo']);

        // 1. Text fields save karein
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // 2. Logo handle karein (agar upload hua ho)
        if ($request->hasFile('restaurant_logo')) {
            $file = $request->file('restaurant_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            
            Setting::updateOrCreate(
                ['key' => 'restaurant_logo'],
                ['value' => 'uploads/settings/' . $filename]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}