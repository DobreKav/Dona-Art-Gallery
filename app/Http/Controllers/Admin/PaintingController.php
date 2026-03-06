<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaintingController extends Controller
{
    public function index()
    {
        $paintings = Painting::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.paintings.index', compact('paintings'));
    }

    public function create()
    {
        return view('admin.paintings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dimensions' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('paintings', 'public');
            $validated['image'] = $path;
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['sort_order'] = $request->input('sort_order', 0);

        Painting::create($validated);

        return redirect()->route('admin.paintings.index')->with('success', 'Сликата е успешно додадена!');
    }

    public function edit(Painting $painting)
    {
        return view('admin.paintings.edit', compact('painting'));
    }

    public function update(Request $request, Painting $painting)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dimensions' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($painting->image) {
                Storage::disk('public')->delete($painting->image);
            }
            $path = $request->file('image')->store('paintings', 'public');
            $validated['image'] = $path;
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $painting->update($validated);

        return redirect()->route('admin.paintings.index')->with('success', 'Сликата е успешно ажурирана!');
    }

    public function destroy(Painting $painting)
    {
        if ($painting->image) {
            Storage::disk('public')->delete($painting->image);
        }

        $painting->delete();

        return redirect()->route('admin.paintings.index')->with('success', 'Сликата е успешно избришана!');
    }
}
