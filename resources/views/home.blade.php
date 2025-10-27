<!DOCTYPE html>
<html>
<head>
<title>Home</title>
</head>
<body>

@if($userRole === 'guru' && $userData)
    <h2>Halo, guru {{ $username }}</h2>
    <p><strong>Nama:</strong> {{ $userData->nama }}</p>
    <p><strong>Mapel:</strong> {{ $userData->mapel }}</p>
    @if($userData->walas)
        <h3>Anda adalah Wali Kelas</h3>
        <p><strong>Kelas:</strong> {{ $userData->walas->jenjang }} {{ $userData->walas->namakelas }}</p>
        <p><strong>Tahun Ajaran:</strong> {{ $userData->walas->tahunajaran }}</p>
    @else
        <h3>Anda bukan Wali Kelas</h3>
        <p>Anda tidak memiliki akses ke data siswa.</p>
    @endif
@elseif($userRole === 'siswa' && $userData)
    <h2>Halo, siswa {{ $username }}</h2>
    <p><strong>Nama:</strong> {{ $userData->nama }}</p>
    <p><strong>BB:</strong> {{ $userData->bb }}</p>
    <p><strong>TB:</strong> {{ $userData->tb }}</p>
    @if($userData->kelas)
        <h3>Kelas:</h3>
        <ul>
            @foreach($userData->kelas as $kelas)
                <li>{{ $kelas->walas->jenjang }} {{ $kelas->walas->namakelas }} (Walas: {{ $kelas->walas->guru->nama ?? '-' }})</li>
            @endforeach
        </ul>
    @endif
@else
    <h2>Halo, Admin</h2>
@endif

<div>
    <a href="{{ route('kbm.index') }}">
        <button>Lihat Jadwal KBM</button>
    </a>
    <a href="{{ route('logout') }}">
        <button>Logout</button>
    </a>
</div>

@if (session('admin_role') === 'admin' || (session('admin_role') === 'guru' && isset($isWalas) && $isWalas))
<h2>Daftar Siswa</h2>
@if (session('admin_role') === 'admin')
<a href="{{ route('siswa.create') }}">
    <button>+ Tambah Siswa</button>
</a>
@endif

<!-- Search Box -->
<p><label>Cari Siswa: </label><input type="text" id="search" placeholder="Ketik nama..."></p>

<!-- Student Table -->
<table id="tabel-siswa" border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tinggi Badan</th>
            <th>Berat Badan</th>
            @if (session('admin_role') === 'admin')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">Memuat data...</td>
        </tr>
    </tbody>
</table>
@endif

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function renderTable(data) {
        let rows = '';
        if (data.length === 0) {
            rows = '<tr><td colspan="5">Tidak ada data ditemukan</td></tr>';
        } else {
            data.forEach((s, index) => {
                rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${s.nama}</td>
                    <td>${s.tb}</td>
                    <td>${s.bb}</td>
                    @if (session('admin_role') === 'admin')
                        <td>
                            <a href="/siswa/${s.id}/edit">Edit</a> |
                            <a href="/siswa/${s.id}/delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    @endif
                </tr>`;
            });
        }
        $('#tabel-siswa tbody').html(rows);
    }

    function loadSiswa() {
        $.ajax({
            url: "{{ route('siswa.data') }}",
            method: "GET",
            success: function(response) {
                renderTable(response);
            },
            error: function() {
                $('#tabel-siswa tbody').html('<tr><td colspan="5">Gagal memuat data siswa.</td></tr>');
            }
        });
    }

    function searchSiswa(keyword) {
        $.ajax({
            url: "{{ route('siswa.search') }}",
            method: "GET",
            data: { q: keyword },
            success: function(response) {
                renderTable(response);
            },
            error: function() {
                console.error('Gagal mencari data siswa.');
            }
        });
    }

    // Initial load
    loadSiswa();

    // Search functionality
    let searchTimer;
    $('#search').on('keyup', function() {
        clearTimeout(searchTimer);
        const keyword = $(this).val().trim();
        
        searchTimer = setTimeout(() => {
            if (keyword.length > 0) {
                searchSiswa(keyword);
            } else {
                loadSiswa();
            }
        }, 300); // 300ms delay
    });
});
</script>
</body>
</html>
