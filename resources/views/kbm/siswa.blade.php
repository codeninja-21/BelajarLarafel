<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas Saya</title>
</head>
<body>
    <div>
        <h2>Jadwal Kelas Saya</h2>
        <div>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            @if($siswa->kelas && $siswa->kelas->first())
                <p><strong>Kelas:</strong> {{ $siswa->kelas->first()->walas->jenjang }} {{ $siswa->kelas->first()->walas->namakelas }}</p>
                <p><strong>Wali Kelas:</strong> {{ $siswa->kelas->first()->walas->guru->nama ?? '-' }}</p>
            @else
                <p>Belum terdaftar di kelas manapun</p>
            @endif
        </div>
        
        <table border="1" cellpadding="8">
            <thead>
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
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jadwal->guru->nama }}</td>
                    <td>{{ $jadwal->guru->mapel }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->mulai }}</td>
                    <td>{{ $jadwal->selesai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Belum ada jadwal pelajaran untuk kelas Anda</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}"><button>Kembali ke Home</button></a>
    </div>
</body>
</html>
