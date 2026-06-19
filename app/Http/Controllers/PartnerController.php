<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $partners = $query->latest()->get();
        return view('partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:supplier,customer,both',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Partner::create($validated);
        return back()->with('success', 'Thêm đối tác thành công!');
    }

    public function update(Request $request, Partner $partner)
    {
        $partner->update($request->all());
        return back()->with('success', 'Cập nhật đối tác thành công!');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return back()->with('success', 'Đã xóa đối tác!');
    }
}
