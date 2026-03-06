<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Painting::where('is_featured', true)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $latest = Painting::where('is_available', true)
            ->latest()
            ->take(8)
            ->get();

        return view('public.home', compact('featured', 'latest'));
    }

    public function bio()
    {
        return view('public.bio');
    }
}
