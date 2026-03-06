@extends('layouts.admin')

@section('title', 'Контролна Табла')
@section('page_title', 'Контролна Табла')

@section('admin_content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="fa-solid fa-palette"></i></div>
        <div class="stat-info">
            <h4>{{ $totalPaintings }}</h4>
            <span>Вкупно Слики</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fa-solid fa-check-circle"></i></div>
        <div class="stat-info">
            <h4>{{ $availablePaintings }}</h4>
            <span>Достапни</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fa-solid fa-clipboard-list"></i></div>
        <div class="stat-info">
            <h4>{{ $totalOrders }}</h4>
            <span>Вкупно Нарачки</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon info"><i class="fa-solid fa-hourglass-half"></i></div>
        <div class="stat-info">
            <h4>{{ $pendingOrders }}</h4>
            <span>Чекаат</span>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr;gap:1.5rem">
    <!-- Recent Orders -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fa-solid fa-clipboard-list" style="color:var(--admin-primary);margin-right:0.5rem"></i> Последни Нарачки</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-sm btn-admin-info">Сите нарачки</a>
        </div>
        <div class="admin-card-body" style="padding:0">
            @if($recentOrders->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Нарачка</th>
                        <th>Клиент</th>
                        <th class="hide-mobile">Град</th>
                        <th>Вкупно</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->full_name }}</td>
                        <td class="hide-mobile">{{ $order->city }}</td>
                        <td>{{ number_format($order->total, 0, '', '.') }} ден.</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ __($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-admin btn-admin-sm btn-admin-info">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="text-align:center;padding:3rem;color:var(--admin-text-light)">
                <i class="fa-solid fa-inbox" style="font-size:2rem;opacity:0.3;margin-bottom:0.5rem;display:block"></i>
                Нема нарачки
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
