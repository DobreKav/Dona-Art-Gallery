<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Painting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPaintings = Painting::count();
        $availablePaintings = Painting::where('is_available', true)->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentOrders = Order::with('items.painting')->latest()->take(5)->get();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');

        return view('admin.dashboard', compact(
            'totalPaintings', 'availablePaintings', 'totalOrders',
            'pendingOrders', 'recentOrders', 'totalRevenue'
        ));
    }
}
