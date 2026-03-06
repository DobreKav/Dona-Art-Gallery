@extends('layouts.admin')

@section('title', 'Додади Слика')
@section('page_title', 'Додади Нова Слика')

@section('admin_content')
<div class="admin-card" style="max-width:800px">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-plus-circle" style="color:var(--admin-primary);margin-right:0.5rem"></i> Нова Слика</h3>
        <a href="{{ route('admin.paintings.index') }}" class="btn-admin btn-admin-sm btn-admin-info">
            <i class="fa-solid fa-arrow-left"></i> Назад
        </a>
    </div>
    <div class="admin-card-body">
        <form action="{{ route('admin.paintings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group-admin">
                <label class="form-label-admin">Слика *</label>
                <div class="image-preview" id="imagePreview">
                    <div class="placeholder">
                        <i class="fa-solid fa-cloud-upload-alt"></i>
                        <span style="font-size:0.8rem">Изберете слика</span>
                    </div>
                </div>
                <input type="file" name="image" accept="image/*" class="form-input-admin" onchange="previewImage(this)" required>
                @error('image') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Име на сликата *</label>
                <input type="text" name="name" class="form-input-admin" placeholder="Внесете име..." value="{{ old('name') }}" required>
                @error('name') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-label-admin">Димензии *</label>
                    <input type="text" name="dimensions" class="form-input-admin" placeholder="нпр. 60x80 cm" value="{{ old('dimensions') }}" required>
                    @error('dimensions') <div class="form-error-admin">{{ $message }}</div> @enderror
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Цена (ден.) *</label>
                    <input type="number" name="price" class="form-input-admin" placeholder="0" value="{{ old('price') }}" min="0" step="100" required>
                    @error('price') <div class="form-error-admin">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-label-admin">Категорија</label>
                    <input type="text" name="category" class="form-input-admin" placeholder="нпр. Пејзаж, Портрет..." value="{{ old('category') }}" list="categories">
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
                    <input type="number" name="sort_order" class="form-input-admin" value="{{ old('sort_order', 0) }}" min="0">
                </div>
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Опис</label>
                <textarea name="description" class="form-input-admin" placeholder="Опишете ја сликата...">{{ old('description') }}</textarea>
                @error('description') <div class="form-error-admin">{{ $message }}</div> @enderror
            </div>

            <div class="form-row-admin">
                <div class="form-group-admin">
                    <label class="form-check">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                        Достапна за продажба
                    </label>
                </div>
                <div class="form-group-admin">
                    <label class="form-check">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        Истакната на почетна
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="submit" class="btn-admin btn-admin-primary" style="padding:0.75rem 2rem">
                    <i class="fa-solid fa-save"></i> Зачувај
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
