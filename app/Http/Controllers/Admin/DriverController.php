<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:drivers',
            'phone'          => 'required|string|max:20',
            'vehicle_type'   => 'required|string',
            'license_number' => 'required|string|unique:drivers',
        ]);

        Driver::create($request->all());

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver added successfully.');
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:drivers,email,' . $driver->id,
            'phone'          => 'required|string|max:20',
            'vehicle_type'   => 'required|string',
            'license_number' => 'required|string|unique:drivers,license_number,' . $driver->id,
        ]);

        $driver->update($request->all());

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver removed successfully.');
    }
}
