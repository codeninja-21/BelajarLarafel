@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Wali Kelas</h2>
        <div>
            <a href="{{ route('walas.edit', $walas->idwalas) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('walas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informasi Wali Kelas</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama Guru</th>
                            <td>{{ $walas->guru->nama ?? 'Tidak ada data guru' }}</td>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <td>{{ $walas->guru->mapel ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $walas->jenjang }} {{ $walas->namakelas }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>{{ $walas->tahunajaran }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Siswa</th>
                            <td>{{ $walas->siswa->count() }} siswa</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Siswa</h5>
                    <a href="{{ route('kelas.create', ['idwalas' => $walas->idwalas]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </a>
                </div>
                <div class="card-body">
                    @if($walas->siswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($walas->siswa as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->id ?? '-' }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>
                                                <form action="{{ route('kelas.destroy', $siswa->kelas->first()->idkelas) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-user-minus"></i> Keluarkan
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">Belum ada siswa di kelas ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Siswa ke Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="idwalas" value="{{ $walas->idwalas }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idsiswa" class="form-label">Pilih Siswa</label>
                        <select class="form-select" id="idsiswa" name="idsiswa" required>
                            <option value="" selected disabled>Pilih Siswa</option>
                            @foreach($availableSiswa as $siswa)
                                <option value="{{ $siswa->idsiswa }}">{{ $siswa->nama }} ({{ $siswa->id ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi modal
    var tambahSiswaModal = new bootstrap.Modal(document.getElementById('tambahSiswaModal'), {
        keyboard: false
    });
    
    // Tampilkan modal saat tombol Tambah Siswa diklik
    document.querySelector('.btn-tambah-siswa').addEventListener('click', function() {
        tambahSiswaModal.show();
    });
</script>
@endpush
