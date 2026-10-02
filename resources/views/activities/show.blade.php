@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>

    @if ($activity->poster_url)
        <img src="{{ $activity->poster_url }}" alt="Poster {{ $activity->title }}" width="200">
    @endif

    <p>Kode: {{ $activity->code ?? '-' }}</p>
    <p>{{ $activity->description }}</p>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category?->name ?? '-' }}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Kapasitas: {{ $activity->registered_count }} / {{ $activity->capacity }} peserta</p>

    <a href="{{ route('activities.index') }}">Kembali</a>
    <a href="{{ route('activities.edit', $activity) }}">Ubah</a>

    <form method="POST"
        action="{{ route('activities.destroy', $activity) }}"
        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>

    {{-- Form Pendaftaran Peserta --}}
    <hr>
    <h3>Daftar Kegiatan Ini</h3>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('activities.register', $activity) }}">
        @csrf
        <label>Nama</label><br>
        <input type="text" name="participant_name" value="{{ old('participant_name') }}"><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>

        <button type="submit">Daftar</button>
    </form>
@endsection