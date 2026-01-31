<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = AppSetting::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'Stockify',
                'logo' => null,
                'language' => 'English',
                'version' => 'v1.0.0',
            ]
        );

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = AppSetting::findOrFail(1);

        $request->validate([
            'app_name' => 'required',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {

            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $path = $request->file('logo')->store('logos','public');
            $setting->logo = $path;
        }

        $setting->app_name = $request->app_name;
        $setting->save();

        return back()->with('success','Settings updated');
    }


}

