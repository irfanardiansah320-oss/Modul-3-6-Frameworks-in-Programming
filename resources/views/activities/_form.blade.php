{{-- 1. Input Kode Kegiatan (Baru) --}}
<label for="code">Kode Kegiatan</label>
<input id="code" name="code" value="{{ old('code', $activity->code ?? '') }}">
@error('code')
    <p class="error">{{ $message }}</p>
@enderror

<label for="title">Judul</label>
<input id="title" name="title" value="{{ old('title', $activity->title ?? '') }}">
@error('title')
    <p class="error">{{ $message }}</p>
@enderror

<label for="description">Deskripsi</label>
<textarea id="description" name="description">{{ old('description', $activity->description ?? '') }}</textarea>
@error('description')
    <p class="error">{{ $message }}</p>
@enderror

<label for="activity_date">Tanggal</label>
<input id="activity_date" name="activity_date" type="date"
    value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}">
@error('activity_date')
    <p class="error">{{ $message }}</p>
@enderror

{{-- 2. Dropdown Kategori (Menggantikan input teks category lama) --}}
<label for="category_id">Kategori</label>
<select id="category_id" name="category_id" required>
    <option value="">-- Pilih kategori --</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}"
            @selected(old('category_id', $activity->category_id ?? null) == $category->id)>
            {{ $category->name }}
        </option>
    @endforeach
</select>
@error('category_id')
    <p class="error">{{ $message }}</p>
@enderror

<label for="status">Status</label>
<select id="status" name="status">
    @foreach (['Planned', 'Ongoing', 'Done'] as $status)
        <option value="{{ $status }}"
            @selected(old('status', $activity->status ?? 'Planned') === $status)>
            {{ $status }}
        </option>
    @endforeach
</select>
@error('status')
    <p class="error">{{ $message }}</p>
@enderror