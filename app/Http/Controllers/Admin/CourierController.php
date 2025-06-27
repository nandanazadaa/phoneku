<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
public function index(Request $request)
{
    Log::info('Courier index method called at ' . now()->format('H:i A, d F Y') . ' WIB');
    $query = Courier::query();
    if ($request->has('q') && $request->q !== '') {
        $q = $request->q;
        $query->where('courier', 'like', "%$q%")
              ->orWhere('service_type', 'like', "%$q%");
    }
    $couriers = $query->latest()->paginate(15);
    Log::info('Admin accessed Courier Management page at ' . now()->format('H:i A, d F Y') . ' WIB with search: ' . $request->q);
    return view('admin.courier', compact('couriers'));
}
    public function store(Request $request)
    {
        $request->validate([
            'courier' => 'required|in:jne,pos,tiki',
            'service_type' => 'required|in:regular,express,economy',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $courier = Courier::create($request->only(['courier', 'service_type', 'shipping_cost']));
        Log::info('New courier added at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Courier method added successfully.');
    }

    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('admin.courier', compact('courier')); // Note: The template handles edit within modals
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'courier' => 'required|in:jne,pos,tiki',
            'service_type' => 'required|in:regular,express,economy',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $courier = Courier::findOrFail($id);
        $courier->update($request->only(['courier', 'service_type', 'shipping_cost']));
        Log::info('Courier updated at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Courier method updated successfully.');
    }

    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();
        Log::info('Courier deleted at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Courier method deleted successfully.');
    }
}