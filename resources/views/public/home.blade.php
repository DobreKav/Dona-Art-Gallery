@extends('layouts.app')

@section('title', 'Дома')
@section('meta_description', 'Dona Art Gallery - Уметничка галерија на Македонка Димова. Оригинални уметнички слики достапни за нарачка.')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--color-bg) 0%, var(--color-bg-warm) 50%, #EDE5D8 100%);
    }

    .hero-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 4rem 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        width: 100%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(139, 105, 20, 0.1);
        color: var(--color-primary);
        padding: 0.5rem 1.2rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .hero-title {
        font-family: var(--font-display);
        font-size: 3.8rem;
        font-weight: 700;
        line-height: 1.15;
        color: var(--color-black);
        margin-bottom: 1.5rem;
    }

    .hero-title .highlight {
        color: var(--color-primary);
        font-style: italic;
    }

    .hero-desc {
        font-size: 1.15rem;
        color: var(--color-text-light);
        line-height: 1.8;
        margin-bottom: 2.5rem;
        max-width: 500px;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-stats {
        display: flex;
        gap: 3rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--color-border);
    }

    .hero-stat-number {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-primary-dark);
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        margin-top: 0.3rem;
    }

    .hero-gallery {
        position: relative;
        height: 600px;
    }

    .hero-img-main {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 65%;
        height: 75%;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        z-index: 2;
    }

    .hero-img-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-img-secondary {
        position: absolute;
        bottom: 5%;
        right: 5%;
        width: 45%;
        height: 50%;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        z-index: 3;
        border: 4px solid white;
    }

    .hero-img-secondary img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-decoration {
        position: absolute;
        top: 0;
        right: 0;
        width: 40%;
        height: 40%;
        background: radial-gradient(circle at center, rgba(139, 105, 20, 0.06) 0%, transparent 70%);
        z-index: 0;
    }

    .hero-float-card {
        position: absolute;
        top: 5%;
        right: 0;
        background: var(--color-white);
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        z-index: 4;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: float 6s ease-in-out infinite;
    }

    .hero-float-card i {
        color: var(--color-primary);
        font-size: 1.2rem;
    }

    .hero-float-card span {
        font-size: 0.85rem;
        font-weight: 500;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Featured section */
    .featured-section {
        background: var(--color-white);
    }

    /* Categories bar */
    .categories-bar {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .category-pill {
        padding: 0.6rem 1.5rem;
        border: 1.5px solid var(--color-border);
        border-radius: 30px;
        font-size: 0.85rem;
        color: var(--color-text-light);
        text-decoration: none;
        transition: var(--transition);
    }

    .category-pill:hover,
    .category-pill.active {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    /* Testimonial / Quote */
    .quote-section {
        background: var(--color-bg-warm);
        text-align: center;
    }

    .quote-text {
        font-family: var(--font-elegant);
        font-size: 2rem;
        font-style: italic;
        color: var(--color-text);
        line-height: 1.5;
        max-width: 800px;
        margin: 0 auto 1.5rem;
    }

    .quote-author {
        font-size: 0.95rem;
        color: var(--color-text-muted);
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--color-black) 0%, #2a2218 100%);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .cta-content {
        position: relative;
        z-index: 1;
    }

    .cta-section .section-title {
        color: white;
    }

    .cta-section .section-desc {
        color: rgba(255,255,255,0.6);
    }

    @media (max-width: 768px) {
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 1.5rem;
        }

        .hero-title {
            font-size: 2.3rem;
        }

        .hero-desc {
            font-size: 1rem;
        }

        .hero-gallery {
            height: 350px;
        }

        .hero-stats {
            gap: 2rem;
        }

        .hero-stat-number {
            font-size: 1.5rem;
        }

        .hero-float-card {
            display: none;
        }

        .quote-text {
            font-size: 1.4rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-decoration"></div>
    <div class="hero-inner">
        <div class="hero-content" data-aos="fade-right">
            <div class="hero-tag">
                <i class="fa-solid fa-palette"></i>
                Уметничка Галерија
            </div>
            <h1 class="hero-title">
                Уметност што ја <span class="highlight">допира</span> душата
            </h1>
            <p class="hero-desc">
                Добредојдовте во светот на Македонка Димова — каде секоја четка остава трага, 
                секоја боја раскажува приказна, а секоја слика е дел од едно уникатно патување.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                    <i class="fa-solid fa-bag-shopping"></i> Разгледај Слики
                </a>
                <a href="{{ route('bio') }}" class="btn btn-secondary btn-lg">
                    <i class="fa-solid fa-user"></i> За Авторката
                </a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-number">{{ \App\Models\Painting::count() ?: '50' }}+</div>
                    <div class="hero-stat-label">Уметнички Дела</div>
                </div>
                <div>
                    <div class="hero-stat-number">15+</div>
                    <div class="hero-stat-label">Години Искуство</div>
                </div>
                <div>
                    <div class="hero-stat-number">100%</div>
                    <div class="hero-stat-label">Оригинални</div>
                </div>
            </div>
        </div>
        <div class="hero-gallery" data-aos="fade-left" data-aos-delay="200">
            <div class="hero-img-main">
                @if($featured->count() > 0 && $featured[0]->image)
                    <img src="{{ asset('storage/' . $featured[0]->image) }}" alt="{{ $featured[0]->name }}">
                @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg, #DDD4C4 0%, #C9A84C 100%);display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-palette" style="font-size:4rem;color:rgba(255,255,255,0.5)"></i>
                    </div>
                @endif
            </div>
            <div class="hero-img-secondary">
                @if($featured->count() > 1 && $featured[1]->image)
                    <img src="{{ asset('storage/' . $featured[1]->image) }}" alt="{{ $featured[1]->name }}">
                @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg, #E8D4B8 0%, #B8860B 100%);display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-image" style="font-size:2rem;color:rgba(255,255,255,0.5)"></i>
                    </div>
                @endif
            </div>
            <div class="hero-float-card">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Бесплатна достава</span>
            </div>
        </div>
    </div>
</section>

<!-- Featured Paintings -->
@if($featured->count() > 0)
<section class="section featured-section">
    <div class="section-inner">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Избрано</div>
            <h2 class="section-title">Истакнати Дела</h2>
            <div class="divider"></div>
            <p class="section-desc">Нашиот избор на најпосебните уметнички дела на Македонка Димова</p>
        </div>
        <div class="paintings-grid">
            @foreach($featured as $painting)
                <div class="painting-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
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
                        <div class="painting-card-meta">{{ $painting->dimensions }} · {{ $painting->category }}</div>
                        <div class="painting-card-price">{{ number_format($painting->price, 0, '', '.') }} ден.</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-outline-gold btn-lg">
                Погледни ги сите <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Quote Section -->
<section class="section quote-section">
    <div class="section-inner" data-aos="fade-up">
        <i class="fa-solid fa-quote-left" style="font-size:2.5rem;color:var(--color-primary-light);opacity:0.4;margin-bottom:1.5rem"></i>
        <p class="quote-text">
            „Уметноста не е она што го гледаш, туку она што ги тера другите да го видат."
        </p>
        <p class="quote-author">— Едгар Дега</p>
    </div>
</section>

<!-- Latest Paintings -->
@if($latest->count() > 0)
<section class="section">
    <div class="section-inner">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Ново</div>
            <h2 class="section-title">Последни Додавања</h2>
            <div class="divider"></div>
        </div>
        <div class="paintings-grid">
            @foreach($latest as $painting)
                <div class="painting-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="painting-card-image">
                        <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}" loading="lazy">
                        <div class="painting-card-overlay">
                            <div class="painting-card-actions">
                                <a href="{{ route('shop.show', $painting) }}" class="btn-icon" title="Погледни">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button class="btn-icon" onclick="addToCart({{ $painting->id }}, this)" title="Додади">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="painting-card-info">
                        <h3><a href="{{ route('shop.show', $painting) }}">{{ $painting->name }}</a></h3>
                        <div class="painting-card-meta">{{ $painting->dimensions }}</div>
                        <div class="painting-card-price">{{ number_format($painting->price, 0, '', '.') }} ден.</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="section cta-section">
    <div class="section-inner cta-content" data-aos="fade-up">
        <div class="section-label" style="color:var(--color-primary-light)">Нарачај Денес</div>
        <h2 class="section-title">Донеси уметност во твојот дом</h2>
        <div class="divider"></div>
        <p class="section-desc">Испорака по карго низ цела Македонија. Секоја слика е оригинал.</p>
        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-bag-shopping"></i> Купи Сега
            </a>
        </div>
    </div>
</section>
@endsection
