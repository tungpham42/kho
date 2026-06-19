<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();

        // Lọc theo Loại đối tác
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Lọc theo Từ khóa tìm kiếm (Mã, Tên, SĐT)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('code', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%');
            });
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
        $validated = $request->validate([
            'type' => 'required|in:supplier,customer,both',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $partner->update($validated);
        return back()->with('success', 'Cập nhật đối tác thành công!');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return back()->with('success', 'Đã xóa đối tác!');
    }
}
