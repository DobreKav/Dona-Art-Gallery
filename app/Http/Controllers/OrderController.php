<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Painting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Кошничката е празна.');
        }

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

        return view('public.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Кошничката е празна.');
        }

        $total = 0;
        $orderItems = [];

        foreach ($cart as $id => $quantity) {
            $painting = Painting::find($id);
            if ($painting) {
                $total += $painting->price * $quantity;
                $orderItems[] = [
                    'painting_id' => $painting->id,
                    'price' => $painting->price,
                    'quantity' => $quantity,
                ];
            }
        }

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'note' => $validated['note'] ?? null,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.success', $order)->with('success', 'Нарачката е успешно направена!');
    }

    public function success(Order $order)
    {
        $order->load('items.painting');
        return view('public.order-success', compact('order'));
    }
}
