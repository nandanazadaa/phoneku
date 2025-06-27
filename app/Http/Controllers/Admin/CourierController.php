<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CourierController extends Controller
{
    /**
     * Display a listing of the couriers.
     */
    public function index()
    {
        Log::info('Courier index method called at ' . now()->format('H:i A, d F Y') . ' WIB');
        $couriers = Courier::all(); // Fetch all couriers for client-side DataTables
        Log::info('Admin accessed Courier Management page at ' . now()->format('H:i A, d F Y') . ' WIB');
        return view('admin.courier', compact('couriers'));
    }

    /**
     * Store a newly created courier in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courier' => 'required|in:jne,pos,tiki,ninja,j&t',
            'service_type' => 'required|in:regular,express,economy',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courier')
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate courier-service type combination
        $exists = Courier::where('courier', $request->courier)
            ->where('service_type', $request->service_type)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.courier')
                ->with('error', 'Kombinasi kurir dan jenis layanan sudah ada.')
                ->withInput();
        }

        $courier = Courier::create($request->only(['courier', 'service_type', 'shipping_cost']));
        Log::info('New courier added at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Metode kurir berhasil ditambahkan.');
    }

    /**
     * Update the specified courier in storage.
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'courier' => 'required|in:jne,pos,tiki,ninja,j&t',
            'service_type' => 'required|in:regular,express,economy',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courier')
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate courier-service type combination, excluding current record
        $exists = Courier::where('courier', $request->courier)
            ->where('service_type', $request->service_type)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.courier')
                ->with('error', 'Kombinasi kurir dan jenis layanan sudah ada.')
                ->withInput();
        }

        $courier->update($request->only(['courier', 'service_type', 'shipping_cost']));
        Log::info('Courier updated at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Metode kurir berhasil diperbarui.');
    }

    /**
     * Remove the specified courier from storage.
     */
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();
        Log::info('Courier deleted at ' . now()->format('H:i A, d F Y') . ' WIB: ' . json_encode($courier));
        return redirect()->route('admin.courier')->with('success', 'Metode kurir berhasil dihapus.');
    }
}