@extends('layouts.admin')

@section('title', 'Измени Слика')
@section('page_title', 'Измени Слика')

@section('admin_content')
<div class="admin-card" style="max-width:800px">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-edit" style="color:var(--admin-primary);margin-right:0.5rem"></i> {{ $painting->name }}</h3>
        <a href="{{ route('admin.paintings.index') }}" class="btn-admin btn-admin-sm btn-admin-info">
            <i class="fa-solid fa-arrow-left"></i> Назад
        </a>
    </div>
    <div class="admin-card-body">
        <form action="{{ route('admin.paintings.update', $painting) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group-admin">
                <label class="form-label-admin">Слика</label>
                <div class="image-preview" id="imagePreview">
                    <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->name }}">
                </div>
                <input type="file" name="image" accept="image/*" class="form-input-admin" onchange="previewImage(this)">
                <small style="color:var(--admin-text-light);font-size:0.78rem">Оставете празно ако не сакате да ја промените сликата</small>
                @error('image') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Име на сликата *</label>
                <input type="text" name="name" class="form-input-admin" value="{{ old('name', $painting->name) }}" required>
                @error('name') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-label-admin">Димензии *</label>
                    <input type="text" name="dimensions" class="form-input-admin" value="{{ old('dimensions', $painting->dimensions) }}" required>
                    @error('dimensions') <div class="form-error-admin">{{ $message }}</div> @enderror
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Цена (ден.) *</label>
                    <input type="number" name="price" class="form-input-admin" value="{{ old('price', $painting->price) }}" min="0" step="100" required>
                    @error('price') <div class="form-error-admin">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-label-admin">Категорија</label>
                    <input type="text" name="category" class="form-input-admin" value="{{ old('category', $painting->category) }}" list="categories">
                    <datalist id="categories">
                        <option value="Пејзаж">
                        <option value="Портрет">
                        <option value="Апстрактно">
                        <option value="Натура морта">
                        <option value="Цвеќиња">
                        <option value="Градски Пејзаж">
                    </datalist>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Редослед</label>
                    <input type="number" name="sort_order" class="form-input-admin" value="{{ old('sort_order', $painting->sort_order) }}" min="0">
                </div>
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Опис</label>
                <textarea name="description" class="form-input-admin">{{ old('description', $painting->description) }}</textarea>
                @error('description') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-check">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $painting->is_available) ? 'checked' : '' }}>
                        Достапна за продажба
                    </label>
                </div>
                <div class="form-group-admin">
                    <label class="form-check">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $painting->is_featured) ? 'checked' : '' }}>
                        Истакната на почетна
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="submit" class="btn-admin btn-admin-primary" style="padding:0.75rem 2rem">
                    <i class="fa-solid fa-save"></i> Ажурирај
                </button>
                <a href="{{ route('admin.paintings.index') }}" class="btn-admin btn-admin-sm" style="padding:0.75rem 2rem;background:var(--admin-bg);color:var(--admin-text)">
                    Откажи
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('admin_scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
