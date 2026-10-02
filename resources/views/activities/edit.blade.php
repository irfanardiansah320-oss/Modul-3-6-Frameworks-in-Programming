@extends('layouts.app')

@section('content')
    <h1>Ubah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.update', $activity) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('activities._form')

        <div>
            <label for="poster">Poster (opsional, maks 2 MB)</label><br>
            @if ($activity->poster_url)
                <img src="{{ $activity->poster_url }}" alt="Poster {{ $activity->title }}" width="150"><br>
            @endif
            <input type="file" name="poster" id="poster" accept="image/*">
            @error('poster') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection