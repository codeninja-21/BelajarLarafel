<!DOCTYPE html>
<html>
<head>
    <title>Jadwal KBM - Admin</title>
</head>
<body>
    <div>
        <h2>Daftar Jadwal Kegiatan Belajar Mengajar (KBM)</h2>
        <p>Role: <strong>Admin</strong> | User: <strong>{{ $username }}</strong></p>
        
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
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
                    <td>{{ $jadwal->walas->jenjang }} {{ $jadwal->walas->namakelas }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->mulai }}</td>
                    <td>{{ $jadwal->selesai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Belum ada jadwal pelajaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}"><button>Kembali ke Home</button></a>
    </div>
</body>
</html>
