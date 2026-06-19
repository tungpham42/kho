<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Lấy record đầu tiên, nếu chưa có thì tạo mới với giá trị mặc định
        $setting = Setting::firstOrCreate([
            'id' => 1
        ], [
            'company_name' => auth()->user()->company_name ?? 'Công ty mặc định',
            'order_prefix' => 'ORD-',
            'transfer_prefix' => 'TRF-',
            'stocktake_prefix' => 'STK-',
        ]);

        return view('settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'order_prefix' => 'required|string|max:10',
            'transfer_prefix' => 'required|string|max:10',
            'stocktake_prefix' => 'required|string|max:10',
        ]);

        $setting = Setting::first();
        if ($setting) {
            $setting->update($validated);
        } else {
            Setting::create($validated);
        }

        return back()->with('success', 'Đã cập nhật cấu hình hệ thống!');
    }
}
