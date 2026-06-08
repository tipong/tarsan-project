<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Makassar');

        $query = Voucher::query();

        if ($request->status === 'active') {
            $query->where('is_active', 1)
                  ->where('starts_at', '<=', $now)
                  ->where('ends_at', '>=', $now);
        }

        if ($request->status === 'inactive') {
            $query->where('is_active', 0);
        }

        if ($request->status === 'scheduled') {
            $query->where('is_active', 1)
                  ->where('starts_at', '>', $now);
        }

        if ($request->status === 'expired') {
            $query->where('ends_at', '<', $now);
        }

        $vouchers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'      => 'required|string|max:50|unique:vouchers,code',
            'amount'    => 'required|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at'   => 'required|date|after:starts_at',
        ]);

        // 🔥 default active
        $validated['is_active'] = 1;

        Voucher::create($validated);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher successfully added');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'code'      => 'required|string|max:255|unique:vouchers,code,' . $voucher->id,
            'amount'    => 'required|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at'   => 'required|date|after:starts_at',
        ]);

        // 🔥 THIS IS THE KEY
        $validated['is_active'] = (int) $request->input('is_active', 0);

        $voucher->update($validated);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher successfully updated');
    }


    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return back()->with('success', 'Voucher successfully deleted');
    }
}
