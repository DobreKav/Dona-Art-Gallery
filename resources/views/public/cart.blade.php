@extends('layouts.app')

@section('title', 'Кошничка')

@section('styles')
<style>
    .cart-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .cart-header h1 {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 600;
    }

    .cart-count-label {
        font-size: 0.9rem;
        color: var(--color-text-muted);
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        text-align: left;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--color-border);
    }

    .cart-item {
        border-bottom: 1px solid var(--color-border-light);
    }

    .cart-item td {
        padding: 1.5rem 0;
        vertical-align: middle;
    }

    .cart-item-info {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .cart-item-img {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
    }

    .cart-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-name {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 500;
    }

    .cart-item-name a {
        text-decoration: none;
        color: var(--color-text);
        transition: color 0.2s;
    }

    .cart-item-name a:hover {
        color: var(--color-primary);
    }

    .cart-item-dims {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-top: 0.2rem;
    }

    .cart-item-price {
        font-family: var(--font-display);
        font-weight: 500;
        font-size: 1rem;
    }

    .quantity-control {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        overflow: hidden;
    }

    .quantity-control button {
        width: 36px;
        height: 36px;
        border: none;
        background: var(--color-bg);
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .quantity-control button:hover {
        background: var(--color-primary);
        color: white;
    }

    .quantity-control span {
        width: 40px;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .cart-item-remove {
        background: none;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.5rem;
        border-radius: 50%;
        transition: var(--transition);
    }

    .cart-item-remove:hover {
        color: var(--color-danger);
        background: rgba(196, 69, 54, 0.08);
    }

    .cart-summary {
        margin-top: 2rem;
        background: var(--color-bg-warm);
        border-radius: var(--radius-lg);
        padding: 2rem;
    }

    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
    }

    .cart-summary-row.total {
        border-top: 2px solid var(--color-border);
        margin-top: 0.5rem;
        padding-top: 1rem;
        font-size: 1.15rem;
        font-weight: 600;
    }

    .cart-summary-row.total .price {
        font-family: var(--font-display);
        font-size: 1.5rem;
        color: var(--color-primary-dark);
    }

    .cart-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .empty-cart {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-cart i {
        font-size: 4rem;
        color: var(--color-text-muted);
        opacity: 0.2;
        margin-bottom: 1.5rem;
    }

    .empty-cart h2 {
        font-family: var(--font-display);
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: var(--color-text-muted);
        margin-bottom: 2rem;
    }

    /* Mobile cart */
    .cart-mobile {
        display: none;
    }

    @media (max-width: 768px) {
        .cart-table {
            display: none;
        }

        .cart-mobile {
            display: block;
        }

        .cart-mobile-item {
            display: flex;
            gap: 1rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--color-border-light);
        }

        .cart-mobile-img {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            flex-shrink: 0;
        }

        .cart-mobile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-mobile-details {
            flex: 1;
        }

        .cart-mobile-name {
            font-family: var(--font-display);
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
        }

        .cart-mobile-dims {
            font-size: 0.8rem;
            color: var(--color-text-muted);
            margin-bottom: 0.5rem;
        }

        .cart-mobile-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-mobile-price {
            font-family: var(--font-display);
            font-weight: 600;
            color: var(--color-primary-dark);
        }

        .cart-actions {
            flex-direction: column;
        }

        .cart-page {
            padding: 2rem 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-page">
    @if(count($items) > 0)
        <div class="cart-header">
            <h1><i class="fa-solid fa-bag-shopping" style="color:var(--color-primary)"></i> Кошничка</h1>
            <span class="cart-count-label">{{ count($items) }} {{ count($items) == 1 ? 'производ' : 'производи' }}</span>
        </div>

        <!-- Desktop table -->
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Производ</th>
                    <th>Цена</th>
                    <th>Количина</th>
                    <th>Вкупно</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="cart-item">
                    <td>
                        <div class="cart-item-info">
                            <div class="cart-item-img">
                                <img src="{{ asset('storage/' . $item['painting']->image) }}" alt="{{ $item['painting']->name }}">
                            </div>
                            <div>
                                <div class="cart-item-name"><a href="{{ route('shop.show', $item['painting']) }}">{{ $item['painting']->name }}</a></div>
                                <div class="cart-item-dims">{{ $item['painting']->dimensions }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="cart-item-price">{{ number_format($item['painting']->price, 0, '', '.') }} ден.</td>
                    <td>
                        <div class="quantity-control">
                            <button onclick="updateQuantity({{ $item['painting']->id }}, {{ $item['quantity'] - 1 }})">−</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button onclick="updateQuantity({{ $item['painting']->id }}, {{ $item['quantity'] + 1 }})">+</button>
                        </div>
                    </td>
                    <td class="cart-item-price">{{ number_format($item['subtotal'], 0, '', '.') }} ден.</td>
                    <td>
                        <form action="{{ route('cart.remove', $item['painting']) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cart-item-remove" title="Отстрани">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mobile layout -->
        <div class="cart-mobile">
            @foreach($items as $item)
            <div class="cart-mobile-item">
                <div class="cart-mobile-img">
                    <img src="{{ asset('storage/' . $item['painting']->image) }}" alt="{{ $item['painting']->name }}">
                </div>
                <div class="cart-mobile-details">
                    <div class="cart-mobile-name">{{ $item['painting']->name }}</div>
                    <div class="cart-mobile-dims">{{ $item['painting']->dimensions }}</div>
                    <div class="cart-mobile-bottom">
                        <div class="cart-mobile-price">{{ number_format($item['subtotal'], 0, '', '.') }} ден.</div>
                        <div style="display:flex;align-items:center;gap:0.75rem">
                            <div class="quantity-control">
                                <button onclick="updateQuantity({{ $item['painting']->id }}, {{ $item['quantity'] - 1 }})">−</button>
                                <span>{{ $item['quantity'] }}</span>
                                <button onclick="updateQuantity({{ $item['painting']->id }}, {{ $item['quantity'] + 1 }})">+</button>
                            </div>
                            <form action="{{ route('cart.remove', $item['painting']) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cart-item-remove"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div class="cart-summary-row">
                <span>Подвкупно</span>
                <span>{{ number_format($total, 0, '', '.') }} ден.</span>
            </div>
            <div class="cart-summary-row">
                <span>Достава (карго)</span>
                <span style="color:var(--color-success)">По договор</span>
            </div>
            <div class="cart-summary-row total">
                <span>Вкупно</span>
                <span class="price">{{ number_format($total, 0, '', '.') }} ден.</span>
            </div>
            <div class="cart-actions">
                <a href="{{ route('shop.index') }}" class="btn btn-secondary btn-lg" style="flex:1;justify-content:center">
                    <i class="fa-solid fa-arrow-left"></i> Продолжи со купување
                </a>
                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg" style="flex:1;justify-content:center">
                    Нарачај <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <i class="fa-solid fa-bag-shopping"></i>
            <h2>Кошничката е празна</h2>
            <p>Разгледајте ја нашата колекција и додадете слики</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-palette"></i> Кон продавница
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function updateQuantity(paintingId, newQty) {
        if (newQty < 1) {
            // Remove item
            window.location.href = '{{ url("/cart/remove") }}/' + paintingId;
            return;
        }
        fetch(`{{ url('/cart/update') }}/${paintingId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ quantity: newQty }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
