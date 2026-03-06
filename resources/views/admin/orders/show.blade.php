@extends('layouts.admin')

@section('title', 'Нарачка #' . $order->order_number)
@section('page_title', 'Детали за Нарачка')

@section('admin_content')
<div style="display:flex;gap:1rem;margin-bottom:1.5rem">
    <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-sm btn-admin-info">
        <i class="fa-solid fa-arrow-left"></i> Назад
    </a>
</div>

<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;align-items:start">
    <!-- Order details -->
    <div>
        <div class="admin-card" style="margin-bottom:1.5rem">
            <div class="admin-card-header">
                <h3><i class="fa-solid fa-receipt" style="color:var(--admin-primary);margin-right:0.5rem"></i> {{ $order->order_number }}</h3>
                <span class="status-badge status-{{ $order->status }}">
                    @switch($order->status)
                        @case('pending') Чека @break
                        @case('confirmed') Потврдена @break
                        @case('shipped') Испратена @break
                        @case('delivered') Доставена @break
                        @case('cancelled') Откажана @break
                    @endswitch
                </span>
            </div>
            <div class="admin-card-body" style="padding:0">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Слика</th>
                            <th>Име</th>
                            <th>Цена</th>
                            <th>Кол.</th>
                            <th>Вкупно</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->painting)
                                    <img src="{{ asset('storage/' . $item->painting->image) }}" class="thumb" alt="{{ $item->painting->name }}">
                                @endif
                            </td>
                            <td><strong>{{ $item->painting->name ?? 'Избришана' }}</strong></td>
                            <td>{{ number_format($item->price, 0, '', '.') }} ден.</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>{{ number_format($item->price * $item->quantity, 0, '', '.') }} ден.</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:600">Вкупно:</td>
                            <td style="font-weight:700;font-size:1.1rem;color:var(--admin-primary)">{{ number_format($order->total, 0, '', '.') }} ден.</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Customer info & status update -->
    <div>
        <div class="admin-card" style="margin-bottom:1.5rem">
            <div class="admin-card-header">
                <h3><i class="fa-solid fa-user" style="color:var(--admin-primary);margin-right:0.5rem"></i> Клиент</h3>
            </div>
            <div class="admin-card-body">
                <div style="display:grid;gap:0.75rem">
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Име и Презиме</div>
                        <div style="font-weight:500">{{ $order->full_name }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Телефон</div>
                        <div style="font-weight:500">{{ $order->phone }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Град</div>
                        <div style="font-weight:500">{{ $order->city }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Адреса</div>
                        <div style="font-weight:500">{{ $order->address }}</div>
                    </div>
                    @if($order->email)
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Е-пошта</div>
                        <div style="font-weight:500">{{ $order->email }}</div>
                    </div>
                    @endif
                    @if($order->note)
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Забелешка</div>
                        <div style="font-weight:500;background:var(--admin-bg);padding:0.5rem 0.75rem;border-radius:6px;font-size:0.88rem">{{ $order->note }}</div>
                    </div>
                    @endif
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-text-light);text-transform:uppercase;letter-spacing:0.05em">Датум</div>
                        <div style="font-weight:500">{{ $order->created_at->format('d.m.Y во H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status update -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3><i class="fa-solid fa-sync" style="color:var(--admin-primary);margin-right:0.5rem"></i> Промени Статус</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group-admin">
                        <select name="status" class="form-input-admin">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🟡 Чека</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>🔵 Потврдена</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🟣 Испратена</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>🟢 Доставена</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>🔴 Откажана</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;justify-content:center;padding:0.65rem">
                        <i class="fa-solid fa-save"></i> Ажурирај Статус
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('admin_styles')
<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns:1.5fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
@endsection
