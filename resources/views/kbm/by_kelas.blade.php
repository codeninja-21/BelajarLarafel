<!DOCTYPE html>
<html>
<head>
    <title>Jadwal KBM - Kelas {{ $kelas->jenjang }} {{ $kelas->namakelas }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Jadwal Kelas {{ $kelas->jenjang }} {{ $kelas->namakelas }}</h2>
        <p><strong>Tahun Ajaran:</strong> {{ $kelas->tahunajaran }}</p>
        <p><strong>Wali Kelas:</strong> {{ $kelas->guru->nama ?? '-' }}</p>
        
        <table class="table table-bordered table-striped align-middle mt-4">
            <thead class="table-primary text-center">
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
                @forelse ($kelas->kbm as $i => $jadwal)
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
                    <td colspan="6" class="text-center text-muted">Belum ada jadwal pelajaran untuk kelas ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</body>
</html>
