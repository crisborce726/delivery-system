<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display all deliveries with assigned drivers.
     */
    public function index()
    {
        $deliveries = Delivery::with(['drivers', 'category'])->latest()->get();

        // Only show drivers that are available
        $availableDrivers = Driver::where('is_available', true)->get()
            ->filter(fn($driver) => $driver->isAvailable());

        return view('admin.deliveries.index', compact('deliveries', 'availableDrivers'));
    }

    /**
     * Assign or update a driver for a delivery.
     */
    public function assignDriver(Request $request, Delivery $delivery)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'notes' => 'nullable|string',
        ]);

        $driver = Driver::findOrFail($request->driver_id);

        // Attach or update driver assignment
        $delivery->drivers()->syncWithoutDetaching([
            $driver->id => [
                'assignment_status' => 'assigned',
                'notes' => $request->notes,
                'completed_at' => null,
            ]
        ]);

        // Update driver availability based on active deliveries
        $hasActiveDeliveries = $driver->deliveries()
            ->wherePivotIn('assignment_status', ['assigned', 'in_progress'])
            ->exists();

        $driver->is_available = !$hasActiveDeliveries;
        $driver->save();

        return redirect()->back()->with('success', "Driver {$driver->name} assigned/updated for delivery {$delivery->tracking_number}.");
    }
}
