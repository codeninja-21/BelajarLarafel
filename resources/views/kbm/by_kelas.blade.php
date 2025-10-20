<!DOCTYPE html>
<html>
<head>
    <title>Jadwal KBM - Kelas {{ $kelas->jenjang }} {{ $kelas->namakelas }}</title>
</head>
<body>
    <div>
        <h2>Jadwal Kelas {{ $kelas->jenjang }} {{ $kelas->namakelas }}</h2>
        <p><strong>Tahun Ajaran:</strong> {{ $kelas->tahunajaran }}</p>
        <p><strong>Wali Kelas:</strong> {{ $kelas->guru->nama ?? '-' }}</p>
        
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
                @forelse ($kelas->kbm as $i => $jadwal)
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
                    <td colspan="6">Belum ada jadwal pelajaran untuk kelas ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('home') }}"><button>Kembali ke Home</button></a>
    </div>
</body>
</html>
