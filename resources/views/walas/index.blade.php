@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Wali Kelas</h2>
        <a href="{{ route('walas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Wali Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Kelas</th>
                    <th>Jenjang</th>
                    <th>Tahun Ajaran</th>
                    <th>Jumlah Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($walas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->guru->nama ?? 'Tidak ada data guru' }}</td>
                        <td>{{ $item->namakelas }}</td>
                        <td>{{ $item->jenjang }}</td>
                        <td>{{ $item->tahunajaran }}</td>
                        <td>{{ $item->siswa->count() }} siswa</td>
                        <td class="d-flex">
                            <a href="{{ route('walas.show', $item->idwalas) }}" class="btn btn-sm btn-info me-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('walas.edit', $item->idwalas) }}" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('walas.destroy', $item->idwalas) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data wali kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
