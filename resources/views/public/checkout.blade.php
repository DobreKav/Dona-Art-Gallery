@extends('layouts.app')

@section('title', 'Нарачка')

@section('styles')
<style>
    .checkout-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    .checkout-header h1 {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .checkout-header p {
        color: var(--color-text-muted);
        margin-bottom: 2rem;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 3rem;
        align-items: start;
    }

    .checkout-form-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        border: 1px solid var(--color-border-light);
    }

    .checkout-form-card h2 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--color-border-light);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .order-summary-card {
        background: var(--color-bg-warm);
        border-radius: var(--radius-lg);
        padding: 2rem;
        position: sticky;
        top: 100px;
    }

    .order-summary-card h2 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--color-border);
    }

    .order-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--color-border-light);
    }

    .order-item-img {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
    }

    .order-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-item-details {
        flex: 1;
    }

    .order-item-name {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .order-item-meta {
        font-size: 0.8rem;
        color: var(--color-text-muted);
    }

    .order-item-price {
        font-weight: 500;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .order-total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        font-size: 0.95rem;
    }

    .order-total-row.grand-total {
        border-top: 2px solid var(--color-border);
        margin-top: 0.5rem;
        padding-top: 1rem;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .order-total-row.grand-total span:last-child {
        font-family: var(--font-display);
        color: var(--color-primary-dark);
        font-size: 1.3rem;
    }

    .checkout-note {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
        padding: 1rem;
        background: rgba(139, 105, 20, 0.06);
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        color: var(--color-text-light);
    }

    .checkout-note i {
        color: var(--color-primary);
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .checkout-page {
            padding: 2rem 1rem;
        }

        .order-summary-card {
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="checkout-page">
    <div class="checkout-header" data-aos="fade-up">
        <h1><i class="fa-solid fa-clipboard-list" style="color:var(--color-primary)"></i> Нарачка</h1>
        <p>Внесете ги вашите податоци за достава</p>
    </div>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="checkout-grid">
            <div class="checkout-form-card" data-aos="fade-up">
                <h2><i class="fa-solid fa-user"></i> Податоци за достава</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Име *</label>
                        <input type="text" name="first_name" class="form-input" placeholder="Вашето име" value="{{ old('first_name') }}" required>
                        @error('first_name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Презиме *</label>
                        <input type="text" name="last_name" class="form-input" placeholder="Вашето презиме" value="{{ old('last_name') }}" required>
                        @error('last_name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Град *</label>
                        <input type="text" name="city" class="form-input" placeholder="Град" value="{{ old('city') }}" required>
                        @error('city') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Телефон *</label>
                        <input type="text" name="phone" class="form-input" placeholder="+389 7X XXX XXX" value="{{ old('phone') }}" required>
                        @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Адреса *</label>
                    <input type="text" name="address" class="form-input" placeholder="Улица и број" value="{{ old('address') }}" required>
                    @error('address') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Е-пошта (опционално)</label>
                    <input type="email" name="email" class="form-input" placeholder="email@example.com" value="{{ old('email') }}">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Забелешка (опционално)</label>
                    <textarea name="note" class="form-input" placeholder="Дополнителни инструкции за доставата...">{{ old('note') }}</textarea>
                    @error('note') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-full mt-2">
                    <i class="fa-solid fa-paper-plane"></i> Потврди Нарачка
                </button>
            </div>

            <div class="order-summary-card" data-aos="fade-up" data-aos-delay="100">
                <h2><i class="fa-solid fa-receipt"></i> Преглед на нарачка</h2>

                @foreach($items as $item)
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="{{ asset('storage/' . $item['painting']->image) }}" alt="{{ $item['painting']->name }}">
                    </div>
                    <div class="order-item-details">
                        <div class="order-item-name">{{ $item['painting']->name }}</div>
                        <div class="order-item-meta">{{ $item['painting']->dimensions }} × {{ $item['quantity'] }}</div>
                    </div>
                    <div class="order-item-price">{{ number_format($item['subtotal'], 0, '', '.') }} ден.</div>
                </div>
                @endforeach

                <div class="order-total-row" style="margin-top:1rem">
                    <span>Подвкупно</span>
                    <span>{{ number_format($total, 0, '',  '.') }} ден.</span>
                </div>
                <div class="order-total-row">
                    <span>Достава</span>
                    <span style="color:var(--color-success)">По договор</span>
                </div>
                <div class="order-total-row grand-total">
                    <span>Вкупно</span>
                    <span>{{ number_format($total, 0, '', '.') }} ден.</span>
                </div>

                <div class="checkout-note">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>Плаќањето се врши при прием на пратката (карго). Ќе бидете контактирани за потврда.</span>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
