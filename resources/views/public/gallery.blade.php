@extends('layouts.app')

@section('title', 'Галерија')

@section('styles')
<style>
    .gallery-hero {
        background: linear-gradient(135deg, var(--color-bg-warm) 0%, #EDE5D8 100%);
        padding: 3rem 2rem;
        text-align: center;
    }

    .gallery-hero h1 {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .gallery-hero p {
        color: var(--color-text-light);
        font-size: 1.05rem;
    }

    .gallery-filters {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        padding: 2rem;
    }

    .gallery-filter {
        padding: 0.5rem 1.2rem;
        border: 1.5px solid var(--color-border);
        border-radius: 30px;
        font-size: 0.85rem;
        color: var(--color-text-light);
        text-decoration: none;
        transition: var(--transition);
        background: var(--color-white);
    }

    .gallery-filter:hover,
    .gallery-filter.active {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    /* Masonry Grid */
    .masonry-grid {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 4rem;
        columns: 3;
        column-gap: 1.5rem;
    }

    .masonry-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }

    .masonry-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .masonry-item img {
        width: 100%;
        display: block;
        transition: transform 0.6s;
    }

    .masonry-item:hover img {
        transform: scale(1.03);
    }

    .masonry-item-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 40%);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
    }

    .masonry-item:hover .masonry-item-overlay {
        opacity: 1;
    }

    .masonry-item-overlay h3 {
        font-family: var(--font-display);
        color: white;
        font-size: 1.15rem;
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    .masonry-item-overlay span {
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
    }

    /* Lightbox */
    .gallery-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .gallery-lightbox.active {
        display: flex;
    }

    .gallery-lightbox img {
        max-width: 90%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: var(--radius-md);
    }

    .gallery-lightbox-info {
        text-align: center;
        margin-top: 1.5rem;
        color: white;
    }

    .gallery-lightbox-info h3 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        margin-bottom: 0.25rem;
    }

    .gallery-lightbox-info span {
        color: rgba(255,255,255,0.6);
        font-size: 0.9rem;
    }

    .gallery-lightbox-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        z-index: 2;
    }

    .gallery-lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.1);
        border: none;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.2rem;
        transition: var(--transition);
    }

    .gallery-lightbox-nav:hover {
        background: rgba(255,255,255,0.2);
    }

    .gallery-lightbox-nav.prev { left: 2rem; }
    .gallery-lightbox-nav.next { right: 2rem; }

    @media (max-width: 1024px) {
        .masonry-grid {
            columns: 2;
        }
    }

    @media (max-width: 768px) {
        .masonry-grid {
            columns: 2;
            padding: 0 1rem 3rem;
            column-gap: 0.75rem;
        }

        .masonry-item {
            margin-bottom: 0.75rem;
            border-radius: var(--radius-sm);
        }

        .gallery-hero h1 {
            font-size: 1.8rem;
        }

        .gallery-lightbox-nav {
            width: 40px;
            height: 40px;
        }

        .gallery-lightbox-nav.prev { left: 0.5rem; }
        .gallery-lightbox-nav.next { right: 0.5rem; }
    }
</style>
@endsection

@section('content')
<section class="gallery-hero">
    <h1 data-aos="fade-up">Галерија</h1>
    <p data-aos="fade-up" data-aos-delay="100">Уживајте во целокупната колекција дела</p>
</section>

<div class="gallery-filters">
    <a href="{{ route('gallery') }}" class="gallery-filter {{ !request('category') || request('category') == 'all' ? 'active' : '' }}">Сите</a>
    @foreach($categories as $cat)
        <a href="{{ route('gallery', ['category' => $cat]) }}" class="gallery-filter {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
    @endforeach
</div>

<div class="masonry-grid">
    @foreach($paintings as $index => $painting)
        <div class="masonry-item" data-aos="fade-up" data-aos-delay="{{ ($index % 6) * 80 }}"
             onclick="openGalleryLightbox({{ $index }})">
            <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}" loading="lazy">
            <div class="masonry-item-overlay">
                <h3>{{ $painting->name }}</h3>
                <span>{{ $painting->dimensions }} @if($painting->category)· {{ $painting->category }}@endif</span>
            </div>
        </div>
    @endforeach
</div>

@if($paintings->count() === 0)
    <div style="text-align:center;padding:4rem 2rem">
        <i class="fa-solid fa-images" style="font-size:3rem;color:var(--color-text-muted);opacity:0.3;margin-bottom:1rem;display:block"></i>
        <h3 style="font-family:var(--font-display);margin-bottom:0.5rem">Нема слики во галеријата</h3>
        <p style="color:var(--color-text-muted)">Скоро ќе бидат додадени нови дела.</p>
    </div>
@endif

<!-- Lightbox -->
<div class="gallery-lightbox" id="galleryLightbox">
    <button class="gallery-lightbox-close" onclick="closeGalleryLightbox()"><i class="fa-solid fa-xmark"></i></button>
    <button class="gallery-lightbox-nav prev" onclick="prevImage()"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="gallery-lightbox-nav next" onclick="nextImage()"><i class="fa-solid fa-chevron-right"></i></button>
    <img id="lightboxImg" src="" alt="">
    <div class="gallery-lightbox-info">
        <h3 id="lightboxTitle"></h3>
        <span id="lightboxMeta"></span>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const paintings = @json($paintingsJson);

    let currentIndex = 0;

    function openGalleryLightbox(index) {
        currentIndex = index;
        showImage();
        document.getElementById('galleryLightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeGalleryLightbox() {
        document.getElementById('galleryLightbox').classList.remove('active');
        document.body.style.overflow = '';
    }

    function showImage() {
        const p = paintings[currentIndex];
        document.getElementById('lightboxImg').src = p.image;
        document.getElementById('lightboxTitle').textContent = p.name;
        document.getElementById('lightboxMeta').textContent = p.dimensions + (p.category ? ' · ' + p.category : '');
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % paintings.length;
        showImage();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + paintings.length) % paintings.length;
        showImage();
    }

    document.addEventListener('keydown', e => {
        if (!document.getElementById('galleryLightbox').classList.contains('active')) return;
        if (e.key === 'Escape') closeGalleryLightbox();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
    });

    document.getElementById('galleryLightbox').addEventListener('click', function(e) {
        if (e.target === this) closeGalleryLightbox();
    });
</script>
@endsection
