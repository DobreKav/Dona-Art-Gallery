@extends('layouts.app')

@section('title', $painting->name)

@section('styles')
<style>
    .painting-detail {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    .breadcrumb {
        display: flex;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--color-text-muted);
        margin-bottom: 2rem;
    }

    .breadcrumb a {
        color: var(--color-text-muted);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: var(--color-primary);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 4rem;
        align-items: start;
    }

    .detail-image-wrapper {
        position: relative;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .detail-image-wrapper img {
        width: 100%;
        display: block;
        cursor: zoom-in;
    }

    .detail-info {
        position: sticky;
        top: 100px;
    }

    .detail-category {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(139, 105, 20, 0.08);
        color: var(--color-primary);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .detail-title {
        font-family: var(--font-display);
        font-size: 2.2rem;
        font-weight: 600;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }

    .detail-dimensions {
        font-size: 0.95rem;
        color: var(--color-text-light);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-price {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-primary-dark);
        margin-bottom: 1.5rem;
    }

    .detail-desc {
        font-size: 1rem;
        color: var(--color-text-light);
        line-height: 1.8;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--color-border-light);
    }

    .detail-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .detail-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--color-bg);
        border-radius: var(--radius-sm);
    }

    .detail-feature i {
        color: var(--color-primary);
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .detail-feature span {
        font-size: 0.85rem;
        color: var(--color-text-light);
    }

    .detail-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .detail-actions .btn {
        flex: 1;
    }

    /* Related */
    .related-section {
        margin-top: 5rem;
        padding-top: 3rem;
        border-top: 1px solid var(--color-border-light);
    }

    /* Lightbox */
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: var(--radius-md);
    }

    .lightbox-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .detail-title {
            font-size: 1.6rem;
        }

        .detail-price {
            font-size: 1.5rem;
        }

        .detail-features {
            grid-template-columns: 1fr;
        }

        .detail-actions {
            flex-direction: column;
        }

        .detail-info {
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="painting-detail">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Дома</a> /
        <a href="{{ route('shop.index') }}">Продавница</a> /
        <span>{{ $painting->name }}</span>
    </div>

    <div class="detail-grid">
        <div class="detail-image-wrapper" data-aos="fade-right" onclick="openLightbox()">
            <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}">
        </div>

        <div class="detail-info" data-aos="fade-left">
            @if($painting->category)
                <div class="detail-category">
                    <i class="fa-solid fa-palette"></i> {{ $painting->category }}
                </div>
            @endif

            <h1 class="detail-title">{{ $painting->name }}</h1>

            <div class="detail-dimensions">
                <i class="fa-solid fa-ruler-combined"></i>
                Димензии: {{ $painting->dimensions }}
            </div>

            <div class="detail-price">{{ number_format($painting->price, 0, '', '.') }} ден.</div>

            @if($painting->description)
                <div class="detail-desc">{{ $painting->description }}</div>
            @endif

            <div class="detail-features">
                <div class="detail-feature">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>Оригинално дело</span>
                </div>
                <div class="detail-feature">
                    <i class="fa-solid fa-truck"></i>
                    <span>Достава по карго</span>
                </div>
                <div class="detail-feature">
                    <i class="fa-solid fa-shield"></i>
                    <span>Заштитено пакување</span>
                </div>
                <div class="detail-feature">
                    <i class="fa-solid fa-certificate"></i>
                    <span>Сертификат</span>
                </div>
            </div>

            <div class="detail-actions">
                <button class="btn btn-primary btn-lg btn-full" onclick="addToCart({{ $painting->id }}, this)">
                    <i class="fa-solid fa-bag-shopping"></i> Додади во кошничка
                </button>
            </div>
            <div class="detail-actions">
                <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-full">
                    <i class="fa-solid fa-eye"></i> Погледни кошничка
                </a>
            </div>
        </div>
    </div>

    @if($related->count() > 0)
    <div class="related-section">
        <div class="section-header">
            <div class="section-label">Слични</div>
            <h2 class="section-title">Поврзани Дела</h2>
            <div class="divider"></div>
        </div>
        <div class="paintings-grid">
            @foreach($related as $item)
                <div class="painting-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="painting-card-image">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                        <div class="painting-card-overlay">
                            <div class="painting-card-actions">
                                <a href="{{ route('shop.show', $item) }}" class="btn-icon"><i class="fa-solid fa-eye"></i></a>
                                <button class="btn-icon" onclick="addToCart({{ $item->id }}, this)"><i class="fa-solid fa-bag-shopping"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="painting-card-info">
                        <h3><a href="{{ route('shop.show', $item) }}">{{ $item->name }}</a></h3>
                        <div class="painting-card-meta">{{ $item->dimensions }}</div>
                        <div class="painting-card-price">{{ number_format($item->price, 0, '', '.') }} ден.</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close"><i class="fa-solid fa-xmark"></i></button>
    <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}">
</div>
@endsection

@section('scripts')
<script>
    function openLightbox() {
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endsection
