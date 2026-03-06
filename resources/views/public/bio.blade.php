@extends('layouts.app')

@section('title', 'За Мене - Македонка Димова')
@section('meta_description', 'Запознајте ја Македонка Димова - уметничка со страст кон сликарството и природата.')

@section('styles')
<style>
    .bio-hero {
        background: linear-gradient(135deg, var(--color-bg-warm) 0%, #EDE5D8 50%, var(--color-bg) 100%);
        padding: 5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .bio-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(139, 105, 20, 0.05) 0%, transparent 70%);
    }

    .bio-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 4rem;
        align-items: center;
    }

    .bio-photo-wrapper {
        position: relative;
    }

    .bio-photo {
        width: 100%;
        aspect-ratio: 3/4;
        background: linear-gradient(135deg, #DDD4C4 0%, #C9A84C 50%, #96764A 100%);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        position: relative;
    }

    .bio-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .bio-photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.6);
    }

    .bio-photo-placeholder i {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .bio-photo-placeholder span {
        font-family: var(--font-elegant);
        font-size: 1.3rem;
        letter-spacing: 0.1em;
    }

    .bio-photo-frame {
        position: absolute;
        top: -15px;
        left: -15px;
        right: 15px;
        bottom: 15px;
        border: 2px solid var(--color-primary-light);
        border-radius: var(--radius-xl);
        opacity: 0.3;
        z-index: -1;
    }

    .bio-content h1 {
        font-family: var(--font-display);
        font-size: 2.8rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .bio-content .subtitle {
        font-family: var(--font-elegant);
        font-size: 1.3rem;
        color: var(--color-primary);
        letter-spacing: 0.1em;
        margin-bottom: 2rem;
    }

    .bio-content p {
        font-size: 1.05rem;
        color: var(--color-text-light);
        line-height: 1.9;
        margin-bottom: 1.5rem;
    }

    .bio-signature {
        font-family: var(--font-display);
        font-style: italic;
        font-size: 1.4rem;
        color: var(--color-primary-dark);
        margin-top: 2rem;
    }

    /* Story section */
    .bio-story {
        background: var(--color-white);
    }

    .bio-story-inner {
        max-width: 900px;
        margin: 0 auto;
    }

    .bio-story-text {
        font-family: var(--font-elegant);
        font-size: 1.2rem;
        color: var(--color-text);
        line-height: 2;
        text-align: center;
    }

    /* Timeline */
    .bio-timeline {
        max-width: 900px;
        margin: 0 auto;
        position: relative;
    }

    .bio-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        background: var(--color-border);
    }

    .timeline-item {
        display: flex;
        margin-bottom: 3rem;
        position: relative;
    }

    .timeline-item:nth-child(odd) {
        flex-direction: row-reverse;
        text-align: right;
    }

    .timeline-content {
        width: 45%;
        padding: 1.5rem;
        background: var(--color-white);
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border-light);
        box-shadow: var(--shadow-sm);
    }

    .timeline-dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--color-primary);
        border: 3px solid var(--color-bg);
        z-index: 2;
    }

    .timeline-year {
        font-family: var(--font-display);
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--color-primary);
        margin-bottom: 0.3rem;
    }

    .timeline-text {
        font-size: 0.95rem;
        color: var(--color-text-light);
        line-height: 1.6;
    }

    /* Values section */
    .values-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .value-card {
        text-align: center;
        padding: 2.5rem 2rem;
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border-light);
        transition: var(--transition);
    }

    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .value-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(139, 105, 20, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .value-icon i {
        font-size: 1.5rem;
        color: var(--color-primary);
    }

    .value-card h3 {
        font-family: var(--font-display);
        font-size: 1.15rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }

    .value-card p {
        font-size: 0.9rem;
        color: var(--color-text-light);
        line-height: 1.7;
    }

    /* Contact section */
    .contact-section {
        background: var(--color-black);
        text-align: center;
        position: relative;
    }

    .contact-section .section-title {
        color: white;
    }

    .contact-section .section-desc {
        color: rgba(255,255,255,0.6);
    }

    .contact-methods {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .contact-method {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255,255,255,0.7);
        font-size: 1rem;
        text-decoration: none;
        transition: color 0.2s;
    }

    .contact-method:hover {
        color: var(--color-primary-light);
    }

    .contact-method i {
        color: var(--color-primary-light);
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .bio-hero-inner {
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }

        .bio-photo-wrapper {
            max-width: 300px;
            margin: 0 auto;
        }

        .bio-content h1 {
            font-size: 2rem;
        }

        .bio-timeline::before {
            left: 20px;
        }

        .timeline-item,
        .timeline-item:nth-child(odd) {
            flex-direction: column;
            text-align: left;
            padding-left: 50px;
        }

        .timeline-content {
            width: 100%;
        }

        .timeline-dot {
            left: 20px;
        }

        .values-grid {
            grid-template-columns: 1fr;
        }

        .bio-photo-frame {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero -->
<section class="bio-hero">
    <div class="bio-hero-inner">
        <div class="bio-photo-wrapper" data-aos="fade-right">
            <div class="bio-photo">
                <div class="bio-photo-placeholder">
                    <i class="fa-solid fa-palette"></i>
                    <span>Македонка Димова</span>
                </div>
            </div>
            <div class="bio-photo-frame"></div>
        </div>

        <div class="bio-content" data-aos="fade-left">
            <h1>Македонка Димова</h1>
            <div class="subtitle">Уметничка · Сликарка · Креаторка</div>
            <p>
                Добредојдовте во мојот свет на бои и емоции. Јас сум Македонка Димова, 
                уметничка со длабока страст кон сликарството и визуелната уметност. Секоја 
                слика што ја создавам е одраз на мојата душа, инспирирана од убавините на 
                природата, животот и човечките емоции.
            </p>
            <p>
                Сликарството за мене не е само хоби — тоа е начин на живот, начин на 
                комуникација и начин да го направам светот малку поубав. Преку четката и 
                боите, ги изразувам чувствата кои зборовите не можат да ги опишат.
            </p>
            <div class="bio-signature">— Македонка Димова</div>
        </div>
    </div>
</section>

<!-- Story -->
<section class="section bio-story">
    <div class="section-inner">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Мојата Приказна</div>
            <h2 class="section-title">За Уметноста и Страста</h2>
            <div class="divider"></div>
        </div>
        <div class="bio-story-inner" data-aos="fade-up">
            <p class="bio-story-text">
                Мојот уметнички пат започна како детска љубопитност кон боите и формите. 
                Со текот на годините, таа љубопитност прерасна во страст која ме води низ 
                бескрајните можности на платното. Работам со масло на платно, акрил, и 
                мешани техники, создавајќи дела кои ги спојуваат традиционалните и 
                современите уметнички пристапи. Секое дело е уникатно, создадено со 
                внимание кон секој детал и со љубов кон процесот на создавање.
            </p>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="section">
    <div class="section-inner">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Патување</div>
            <h2 class="section-title">Уметнички Пат</h2>
            <div class="divider"></div>
        </div>
        <div class="bio-timeline">
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-content">
                    <div class="timeline-year">Почетоци</div>
                    <div class="timeline-text">Првите чекори во уметноста, откривање на талентот и страста кон сликарството.</div>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                <div class="timeline-content">
                    <div class="timeline-year">Образование</div>
                    <div class="timeline-text">Усовршување на техниките и стилот преку континуирано учење и експериментирање.</div>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                <div class="timeline-content">
                    <div class="timeline-year">Развој</div>
                    <div class="timeline-text">Создавање на препознатлив стил и колекција уметнички дела инспирирани од природата и емоциите.</div>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                <div class="timeline-content">
                    <div class="timeline-year">Денес</div>
                    <div class="timeline-text">Активно создавање и споделување на уметноста со љубителите ширум Македонија и пошироко.</div>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section" style="background:var(--color-bg-warm)">
    <div class="section-inner">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Филозофија</div>
            <h2 class="section-title">Зошто Мојата Уметност</h2>
            <div class="divider"></div>
        </div>
        <div class="values-grid">
            <div class="value-card" data-aos="fade-up">
                <div class="value-icon"><i class="fa-solid fa-fingerprint"></i></div>
                <h3>100% Оригинали</h3>
                <p>Секое дело е единствено и создадено рачно. Не постојат две исти слики — секоја е уникатен оригинал.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="value-icon"><i class="fa-solid fa-heart"></i></div>
                <h3>Со Душа и Емоција</h3>
                <p>Секоја четка е водена од емоции и инспирација. Уметноста создадена од срце, за вашиот дом.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="value-icon"><i class="fa-solid fa-gem"></i></div>
                <h3>Квалитетни Материјали</h3>
                <p>Користам најквалитетни бои и платна за да обезбедам трајност и живост на боите со години.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                <div class="value-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h3>Безбедна Достава</h3>
                <p>Секоја слика е професионално спакувана и испратена по карго до вашата адреса низ Македонија.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="400">
                <div class="value-icon"><i class="fa-solid fa-certificate"></i></div>
                <h3>Сертификат</h3>
                <p>Секое дело доаѓа со сертификат за автентичност потпишан од авторката.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="500">
                <div class="value-icon"><i class="fa-solid fa-handshake"></i></div>
                <h3>Директен Контакт</h3>
                <p>Комуницирате директно со авторката за секое прашање, нарачка или специјално барање.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="section contact-section">
    <div class="section-inner" data-aos="fade-up">
        <div class="section-label" style="color:var(--color-primary-light)">Контакт</div>
        <h2 class="section-title">Поврзете Се Со Мене</h2>
        <div class="divider"></div>
        <p class="section-desc">Доколку имате прашања, сакате нарачка по мерка или едноставно да разговарате за уметност</p>
        <div class="contact-methods">
            <a href="#" class="contact-method">
                <i class="fa-solid fa-phone"></i>
                <span>+389 XX XXX XXX</span>
            </a>
            <a href="#" class="contact-method">
                <i class="fa-solid fa-envelope"></i>
                <span>info@donaart.mk</span>
            </a>
            <a href="#" class="contact-method">
                <i class="fa-brands fa-instagram"></i>
                <span>@dona_art_gallery</span>
            </a>
            <a href="#" class="contact-method">
                <i class="fa-brands fa-facebook"></i>
                <span>Dona Art Gallery</span>
            </a>
        </div>
        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-palette"></i> Погледни ги Делата
            </a>
        </div>
    </div>
</section>
@endsection
