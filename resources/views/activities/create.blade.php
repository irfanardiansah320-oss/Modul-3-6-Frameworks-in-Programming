@extends('layouts.app')

@section('content')
    <h1>Tambah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.store') }}">
        @csrf
        @include('activities._form')
        <button type="submit">Simpan</button>
    </form>
@endsection