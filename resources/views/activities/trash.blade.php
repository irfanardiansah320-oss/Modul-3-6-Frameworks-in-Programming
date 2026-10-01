<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kegiatan Terhapus</title>
</head>
<body>
    <h1>Kegiatan Terhapus (Sampah)</h1>
    <p><a href="{{ route('activities.index') }}">← Kembali ke Daftar Kegiatan</a></p>

    @if (session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Dihapus Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr>
                    <td>{{ $activity->code }}</td>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->category?->name ?? '-' }}</td>
                    <td>{{ $activity->deleted_at }}</td>
                    <td>
                        <form action="{{ route('activities.restore', $activity) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Pulihkan</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada kegiatan terhapus.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        {{ $activities->links() }}
    </div>
</body>
</html>
