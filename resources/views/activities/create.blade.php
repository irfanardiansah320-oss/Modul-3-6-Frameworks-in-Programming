@extends('layouts.app')

@section('content')
    <h1>Tambah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.store') }}" enctype="multipart/form-data">
        @csrf
        @include('activities._form')

        <div>
            <label for="poster">Poster (opsional, maks 2 MB)</label><br>
            <input type="file" name="poster" id="poster" accept="image/*">
            @error('poster') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection