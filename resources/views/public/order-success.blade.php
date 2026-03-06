@extends('layouts.app')

@section('title', 'Успешна Нарачка')

@section('styles')
<style>
    .success-page {
        max-width: 700px;
        margin: 0 auto;
        padding: 4rem 2rem;
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(74, 124, 89, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }

    .success-icon i {
        font-size: 2rem;
        color: var(--color-success);
    }

    .success-page h1 {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .success-page .subtitle {
        color: var(--color-text-muted);
        font-size: 1.05rem;
        margin-bottom: 2rem;
    }

    .order-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        border: 1px solid var(--color-border-light);
        text-align: left;
        margin-bottom: 2rem;
    }

    .order-card h3 {
        font-family: var(--font-display);
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--color-border-light);
    }

    .order-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .order-detail-row .label {
        color: var(--color-text-muted);
    }

    .order-items-list {
        margin-top: 1rem;
    }

    .order-items-list .item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--color-border-light);
        align-items: center;
    }

    .order-items-list .item img {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-sm);
        object-fit: cover;
    }

    .order-items-list .item-name {
        flex: 1;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .order-items-list .item-price {
        font-weight: 500;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .success-page {
            padding: 2rem 1rem;
        }

        .success-page h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="success-page" data-aos="fade-up">
    <div class="success-icon">
        <i class="fa-solid fa-check"></i>
    </div>
    <h1>Нарачката е успешна!</h1>
    <p class="subtitle">Ви благодариме за довербата. Ќе бидете контактирани наскоро.</p>

    <div class="order-card">
        <h3><i class="fa-solid fa-receipt" style="color:var(--color-primary);margin-right:0.5rem"></i> Детали за нарачката</h3>
        <div class="order-detail-row">
            <span class="label">Број на нарачка</span>
            <span><strong>{{ $order->order_number }}</strong></span>
        </div>
        <div class="order-detail-row">
            <span class="label">Име</span>
            <span>{{ $order->full_name }}</span>
        </div>
        <div class="order-detail-row">
            <span class="label">Град</span>
            <span>{{ $order->city }}</span>
        </div>
        <div class="order-detail-row">
            <span class="label">Адреса</span>
            <span>{{ $order->address }}</span>
        </div>
        <div class="order-detail-row">
            <span class="label">Телефон</span>
            <span>{{ $order->phone }}</span>
        </div>

        <div class="order-items-list">
            @foreach($order->items as $item)
            <div class="item">
                <img src="{{ asset('storage/' . $item->painting->image) }}" alt="{{ $item->painting->name }}">
                <span class="item-name">{{ $item->painting->name }}</span>
                <span class="item-price">{{ number_format($item->price, 0, '', '.') }} ден.</span>
            </div>
            @endforeach
        </div>

        <div class="order-detail-row" style="margin-top:1rem;font-size:1.1rem;font-weight:600;padding-top:1rem;border-top:2px solid var(--color-border)">
            <span>Вкупно</span>
            <span style="color:var(--color-primary-dark);font-family:var(--font-display);font-size:1.3rem">{{ number_format($order->total, 0, '', '.') }} ден.</span>
        </div>
    </div>

    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
            <i class="fa-solid fa-palette"></i> Продолжи со купување
        </a>
        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
            <i class="fa-solid fa-house"></i> Дома
        </a>
    </div>
</div>
@endsection
