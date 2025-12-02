<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{

    public function index()
    {
        // Fetch deliveries of the logged-in user
        $deliveries = Delivery::where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        return view('user.deliveries.index', compact('deliveries'));
    }


    /**
     * Show the create delivery form
     */
    public function create()
    {
        $categories = Category::all();

        return view('user.deliveries.create', compact('categories'));
    }

    /**
     * Store a new delivery
     */
    public function store(Request $request)
{
    $request->validate([
        'description' => 'required|string',
        'delivery_address' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ]);

    $trackingNumber = Delivery::generateTrackingNumber();

    Delivery::create([
        'user_id' => Auth::user()->id,
        'category_id' => $request->category_id,
        'tracking_number' => $trackingNumber,
        'description' => $request->description,
        'delivery_address' => $request->delivery_address,
        'status' => 'pending',
    ]);

    return redirect()->route('user.deliveries.index')
        ->with('success', "Delivery created successfully! Tracking Number: $trackingNumber");
}

}
