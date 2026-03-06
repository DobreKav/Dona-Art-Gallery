<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $painting = Painting::find($id);
            if ($painting) {
                $items[] = [
                    'painting' => $painting,
                    'quantity' => $quantity,
                    'subtotal' => $painting->price * $quantity,
                ];
                $total += $painting->price * $quantity;
            }
        }

        return view('public.cart', compact('items', 'total'));
    }

    public function add(Request $request, Painting $painting)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$painting->id])) {
            $cart[$painting->id]++;
        } else {
            $cart[$painting->id] = 1;
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Сликата е додадена во кошничката!',
                'cartCount' => array_sum($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Сликата е додадена во кошничката!');
    }

    public function update(Request $request, Painting $painting)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->quantity);

        $cart[$painting->id] = $quantity;
        session()->put('cart', $cart);

        if ($request->ajax()) {
            $total = 0;
            foreach ($cart as $id => $qty) {
                $p = Painting::find($id);
                if ($p) $total += $p->price * $qty;
            }
            return response()->json([
                'success' => true,
                'cartCount' => array_sum($cart),
                'itemTotal' => number_format($painting->price * $quantity, 0, '', '.'),
                'total' => number_format($total, 0, '', '.'),
            ]);
        }

        return redirect()->back();
    }

    public function remove(Painting $painting)
    {
        $cart = session()->get('cart', []);
        unset($cart[$painting->id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Сликата е отстранета од кошничката.');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => array_sum($cart)]);
    }
}
