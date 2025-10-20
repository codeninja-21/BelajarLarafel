<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Mengajar Saya</title>
</head>
<body>
    <div>
        <h2>Jadwal Mengajar Saya</h2>
        <div>
            <p><strong>Nama:</strong> {{ $guru->nama }}</p>
            <p><strong>Mata Pelajaran:</strong> {{ $guru->mapel }}</p>
            <p><strong>Role:</strong> Guru</p>
        </div>
        
        <table border="1" cellpadding="8">
            <thead>
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
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jadwal->walas->jenjang }} {{ $jadwal->walas->namakelas }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->mulai }}</td>
                    <td>{{ $jadwal->selesai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Anda belum memiliki jadwal mengajar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}"><button>Kembali ke Home</button></a>
    </div>
</body>
</html>
