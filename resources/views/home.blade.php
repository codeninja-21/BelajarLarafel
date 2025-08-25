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
@elseif($userRole === 'siswa' && $userData)
    <h2>Halo, siswa {{ $username }}</h2>
    <p><strong>Nama:</strong> {{ $userData->nama }}</p>
    <p><strong>BB:</strong> {{ $userData->bb }}</p>
    <p><strong>TB:</strong> {{ $userData->tb }}</p>
@else
    <h2>Halo, Admin</h2>
@endif

<a href="{{ route('logout') }}">Logout</a>
<h2>Daftar Siswa</h2>
@if (session('admin_role') === 'admin')

<a href="{{ route('siswa.create') }}">
<button>+ Tambah Siswa</button>
</a>
@endif

<table border="1" cellpadding="8">
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
@foreach($siswa as $i => $s)
<tr>
<td>{{ $i + 1 }}</td>
<td>{{ $s->nama }}</td>
<td>{{ $s->tb }}</td>
<td>{{ $s->bb }}</td>
@if (session('admin_role') === 'admin')
<td>
<a href="{{ route('siswa.edit', $s->id) }}">Edit</a> |
<a href="{{ route('siswa.delete', $s->id) }}" onclick="return confirm('Yakin
ingin menghapus?')">Hapus</a>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
