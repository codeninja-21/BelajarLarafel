<!DOCTYPE html>
<html>
<head>
    <title>Jadwal KBM - {{ $guru->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Jadwal Mengajar: {{ $guru->nama }}</h2>
        <p><strong>Mata Pelajaran:</strong> {{ $guru->mapel }}</p>
        
        <table class="table table-bordered table-striped align-middle mt-4">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guru->kbm as $i => $jadwal)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $jadwal->walas->jenjang }} {{ $jadwal->walas->namakelas }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->mulai }}</td>
                    <td>{{ $jadwal->selesai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada jadwal mengajar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</body>
</html>
