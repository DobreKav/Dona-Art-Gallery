<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Painting::where('is_available', true);

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $paintings = $query->paginate(12);
        $categories = Painting::where('is_available', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('public.shop', compact('paintings', 'categories'));
    }

    public function show(Painting $painting)
    {
        $related = Painting::where('id', '!=', $painting->id)
            ->where('is_available', true)
            ->where('category', $painting->category)
            ->take(4)
            ->get();

        return view('public.painting', compact('painting', 'related'));
    }
}
