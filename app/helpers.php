<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

/**
 * Database se setting ki value nikalne ke liye
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

/**
 * Settings wali images/logo ka path nikalne ke liye
 */
if (!function_exists('get_setting_image')) {
    function get_setting_image($key, $default = null) {
        $path = get_setting($key);
        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        return $default ?? asset('backend/assets/images/no-image.png');
    }
}