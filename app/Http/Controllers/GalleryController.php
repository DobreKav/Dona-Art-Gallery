<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Painting::orderBy('sort_order');

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $paintings = $query->get();
        $categories = Painting::whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $paintingsJson = $paintings->map(function ($p) {
            return [
                'image' => asset('storage/' . $p->image),
                'name' => $p->name,
                'dimensions' => $p->dimensions,
                'category' => $p->category,
            ];
        })->values();

        return view('public.gallery', compact('paintings', 'categories', 'paintingsJson'));
    }
}
