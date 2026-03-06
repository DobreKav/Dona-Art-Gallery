@extends('layouts.app')

@section('title', 'Продавница')

@section('styles')
<style>
    .shop-hero {
        background: linear-gradient(135deg, var(--color-bg-warm) 0%, #EDE5D8 100%);
        padding: 3rem 2rem;
        text-align: center;
    }

    .shop-hero h1 {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .shop-hero p {
        color: var(--color-text-light);
        font-size: 1.05rem;
    }

    .shop-toolbar {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .shop-filters {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 0.5rem 1.2rem;
        border: 1.5px solid var(--color-border);
        border-radius: 30px;
        font-size: 0.82rem;
        color: var(--color-text-light);
        text-decoration: none;
        transition: var(--transition);
        background: var(--color-white);
        cursor: pointer;
    }

    .filter-pill:hover,
    .filter-pill.active {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    .shop-sort select {
        padding: 0.5rem 1rem;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        color: var(--color-text);
        background: var(--color-white);
        cursor: pointer;
        outline: none;
    }

    .shop-sort select:focus {
        border-color: var(--color-primary);
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--color-white);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 0 1rem;
        transition: var(--transition);
    }

    .search-box:focus-within {
        border-color: var(--color-primary);
    }

    .search-box input {
        border: none;
        outline: none;
        padding: 0.5rem 0;
        font-size: 0.85rem;
        background: transparent;
        width: 200px;
    }

    .search-box i {
        color: var(--color-text-muted);
        font-size: 0.85rem;
    }

    .shop-grid-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 4rem;
    }

    .shop-results {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        margin-bottom: 1.5rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination-wrapper nav {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-wrapper .page-link {
        padding: 0.5rem 1rem;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        text-decoration: none;
        color: var(--color-text);
        font-size: 0.85rem;
        transition: var(--transition);
    }

    .pagination-wrapper .page-link:hover,
    .pagination-wrapper .page-item.active .page-link {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--color-text-muted);
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--color-text-muted);
    }

    @media (max-width: 768px) {
        .shop-hero h1 {
            font-size: 1.8rem;
        }

        .shop-toolbar {
            padding: 1rem;
        }

        .search-box input {
            width: 150px;
        }

        .shop-grid-wrapper {
            padding: 0 1rem 3rem;
        }
    }
</style>
@endsection

@section('content')
<section class="shop-hero">
    <h1 data-aos="fade-up">Продавница</h1>
    <p data-aos="fade-up" data-aos-delay="100">Разгледајте ја колекцијата уметнички слики</p>
</section>

<div class="shop-toolbar">
    <div class="shop-filters">
        <a href="{{ route('shop.index') }}" class="filter-pill {{ !request('category') || request('category') == 'all' ? 'active' : '' }}">Сите</a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category' => $cat]) }}" class="filter-pill {{ request('category') == $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap">
        <form action="{{ route('shop.index') }}" method="GET" class="search-box">
            <i class="fa-solid fa-search"></i>
            <input type="text" name="search" placeholder="Пребарај..." value="{{ request('search') }}">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>

        <div class="shop-sort">
            <select onchange="window.location.href=this.value">
                <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Најнови</option>
                <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена ↑</option>
                <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
                <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Име</option>
            </select>
        </div>
    </div>
</div>

<div class="shop-grid-wrapper">
    <div class="shop-results">
        Прикажани {{ $paintings->count() }} од {{ $paintings->total() }} слики
    </div>

    @if($paintings->count() > 0)
        <div class="paintings-grid">
            @foreach($paintings as $painting)
                <div class="painting-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                    @if($painting->is_featured)
                        <span class="painting-card-badge">Истакнато</span>
                    @endif
                    <div class="painting-card-image">
                        <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}" loading="lazy">
                        <div class="painting-card-overlay">
                            <div class="painting-card-actions">
                                <a href="{{ route('shop.show', $painting) }}" class="btn-icon" title="Погледни">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button class="btn-icon" onclick="addToCart({{ $painting->id }}, this)" title="Додади во кошничка">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="painting-card-info">
                        <h3><a href="{{ route('shop.show', $painting) }}">{{ $painting->name }}</a></h3>
                        <div class="painting-card-meta">{{ $painting->dimensions }} @if($painting->category)· {{ $painting->category }}@endif</div>
                        <div class="painting-card-price">{{ number_format($painting->price, 0, '', '.') }} ден.</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $paintings->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-palette"></i>
            <h3>Нема пронајдени слики</h3>
            <p>Обидете се со различни филтри или пребарување.</p>
        </div>
    @endif
</div>
@endsection
