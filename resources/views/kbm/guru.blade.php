<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Mengajar Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Jadwal Mengajar Saya</h2>
        <div class="card mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Nama:</strong> {{ $guru->nama }}</p>
                <p class="mb-1"><strong>Mata Pelajaran:</strong> {{ $guru->mapel }}</p>
                <p class="mb-0"><strong>Role:</strong> Guru</p>
            </div>
        </div>
        
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success text-center">
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
                    <td colspan="5" class="text-center text-muted">Anda belum memiliki jadwal mengajar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</body>
</html>
