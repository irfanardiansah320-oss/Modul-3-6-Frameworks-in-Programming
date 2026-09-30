@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>
    <a href="{{ route('activities.create') }}">+ Tambah Kegiatan</a>

    {{-- Pesan Sukses / Error --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 4px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form Search, Filter, & Sort --}}
    <form method="GET" action="{{ route('activities.index') }}" style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/kode...">

        <select name="category_id">
            <option value="">-- Semua Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">-- Semua Status --</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="Planned" {{ request('status') == 'Planned' ? 'selected' : '' }}>Planned</option>
            <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
        </select>

        <select name="sort">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    {{-- List Kegiatan --}}
    @forelse ($activities as $activity)
        <article class="card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    [{{ $activity->code }}] {{ $activity->title }}
                </a>
            </h2>
            <p>Kategori: {{ $activity->category?->name ?? '-' }}</p>
            <p>Tanggal: {{ $activity->activity_date?->format('d M Y') }}</p>
            <p>Status: <strong>{{ ucfirst($activity->status) }}</strong></p>

            {{-- Tombol Transisi Status --}}
            <div style="margin-top: 10px;">
                @if(in_array($activity->status, ['draft', 'Planned']))
                    <form method="POST" action="{{ route('activities.publish', $activity) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Publish</button>
                    </form>
                @elseif(in_array($activity->status, ['published', 'Ongoing']))
                    <form method="POST" action="{{ route('activities.complete', $activity) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Selesaikan</button>
                    </form>
                @else
                    <span style="color: gray;">Selesai</span>
                @endif
            </div>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse

    {{-- Paginasi --}}
    <div style="margin-top: 20px;">
        {{ $activities->links() }}
    </div>
@endsection