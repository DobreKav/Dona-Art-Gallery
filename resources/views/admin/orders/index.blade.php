@extends('layouts.admin')

@section('title', 'Нарачки')
@section('page_title', 'Нарачки')

@section('admin_content')
<div style="display:flex;gap:0.5rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-sm {{ !request('status') || request('status') == 'all' ? 'btn-admin-primary' : '' }}" style="{{ !request('status') || request('status') == 'all' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Сите
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn-admin btn-admin-sm {{ request('status') == 'pending' ? 'btn-admin-primary' : '' }}" style="{{ request('status') == 'pending' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Чекаат
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="btn-admin btn-admin-sm {{ request('status') == 'confirmed' ? 'btn-admin-primary' : '' }}" style="{{ request('status') == 'confirmed' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Потврдени
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="btn-admin btn-admin-sm {{ request('status') == 'shipped' ? 'btn-admin-primary' : '' }}" style="{{ request('status') == 'shipped' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Испратени
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn-admin btn-admin-sm {{ request('status') == 'delivered' ? 'btn-admin-primary' : '' }}" style="{{ request('status') == 'delivered' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Доставени
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="btn-admin btn-admin-sm {{ request('status') == 'cancelled' ? 'btn-admin-primary' : '' }}" style="{{ request('status') == 'cancelled' ? '' : 'background:var(--admin-bg);color:var(--admin-text)' }}">
        Откажани
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-clipboard-list" style="color:var(--admin-primary);margin-right:0.5rem"></i> Нарачки</h3>
    </div>
    <div class="admin-card-body" style="padding:0">
        @if($orders->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Нарачка</th>
                    <th>Клиент</th>
                    <th class="hide-mobile">Телефон</th>
                    <th class="hide-mobile">Град</th>
                    <th>Вкупно</th>
                    <th>Статус</th>
                    <th>Акции</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->order_number }}</strong>
                        <div style="font-size:0.75rem;color:var(--admin-text-light)">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                    </td>
                    <td>{{ $order->full_name }}</td>
                    <td class="hide-mobile">{{ $order->phone }}</td>
                    <td class="hide-mobile">{{ $order->city }}</td>
                    <td><strong>{{ number_format($order->total, 0, '', '.') }} ден.</strong></td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            @switch($order->status)
                                @case('pending') Чека @break
                                @case('confirmed') Потврдена @break
                                @case('shipped') Испратена @break
                                @case('delivered') Доставена @break
                                @case('cancelled') Откажана @break
                            @endswitch
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:0.4rem">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-admin btn-admin-sm btn-admin-info">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Избриши нарачка?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-sm btn-admin-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="admin-pagination" style="padding:1rem">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @else
        <div style="text-align:center;padding:3rem;color:var(--admin-text-light)">
            <i class="fa-solid fa-inbox" style="font-size:2rem;opacity:0.3;margin-bottom:0.5rem;display:block"></i>
            Нема нарачки
        </div>
        @endif
    </div>
</div>
@endsection
