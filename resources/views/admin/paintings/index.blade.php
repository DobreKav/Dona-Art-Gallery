@extends('layouts.admin')

@section('title', 'Слики')
@section('page_title', 'Управување со Слики')

@section('admin_content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-palette" style="color:var(--admin-primary);margin-right:0.5rem"></i> Сите Слики ({{ $paintings->count() }})</h3>
        <a href="{{ route('admin.paintings.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> Додади Слика
        </a>
    </div>
    <div class="admin-card-body" style="padding:0">
        @if($paintings->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Слика</th>
                    <th>Име</th>
                    <th class="hide-mobile">Димензии</th>
                    <th class="hide-mobile">Категорија</th>
                    <th>Цена</th>
                    <th class="hide-mobile">Статус</th>
                    <th>Акции</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paintings as $painting)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $painting->image) }}" class="thumb" alt="{{ $painting->name }}">
                    </td>
                    <td>
                        <strong>{{ $painting->name }}</strong>
                        @if($painting->is_featured)
                            <span class="status-badge status-confirmed" style="margin-left:0.3rem">⭐</span>
                        @endif
                    </td>
                    <td class="hide-mobile">{{ $painting->dimensions }}</td>
                    <td class="hide-mobile">{{ $painting->category ?? '-' }}</td>
                    <td><strong>{{ number_format($painting->price, 0, '', '.') }} ден.</strong></td>
                    <td class="hide-mobile">
                        @if($painting->is_available)
                            <span class="status-badge status-delivered">Достапна</span>
                        @else
                            <span class="status-badge status-cancelled">Недостапна</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.4rem">
                            <a href="{{ route('admin.paintings.edit', $painting) }}" class="btn-admin btn-admin-sm btn-admin-warning">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.paintings.destroy', $painting) }}" method="POST" onsubmit="return confirm('Дали сте сигурни?')">
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
        @else
        <div style="text-align:center;padding:3rem;color:var(--admin-text-light)">
            <i class="fa-solid fa-palette" style="font-size:2rem;opacity:0.3;margin-bottom:0.5rem;display:block"></i>
            Нема додадени слики
            <br><br>
            <a href="{{ route('admin.paintings.create') }}" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-plus"></i> Додади Прва Слика
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
