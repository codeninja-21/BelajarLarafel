<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Jadwal Kelas Saya</h2>
        <div class="card mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Nama:</strong> {{ $siswa->nama }}</p>
                @if($siswa->kelas && $siswa->kelas->first())
                    <p class="mb-1"><strong>Kelas:</strong> {{ $siswa->kelas->first()->walas->jenjang }} {{ $siswa->kelas->first()->walas->namakelas }}</p>
                    <p class="mb-0"><strong>Wali Kelas:</strong> {{ $siswa->kelas->first()->walas->guru->nama ?? '-' }}</p>
                @else
                    <p class="mb-0 text-muted">Belum terdaftar di kelas manapun</p>
                @endif
            </div>
        </div>
        
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-info text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $i => $jadwal)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $jadwal->guru->nama }}</td>
                    <td>{{ $jadwal->guru->mapel }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->mulai }}</td>
                    <td>{{ $jadwal->selesai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada jadwal pelajaran untuk kelas Anda</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</body>
</html>
