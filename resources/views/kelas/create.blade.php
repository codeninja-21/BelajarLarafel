@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Siswa ke Kelas</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kelas.store') }}">
                        @csrf
                        
                        <input type="hidden" name="idwalas" value="{{ $idwalas }}">
                        
                        <div class="mb-3">
                            <label for="idsiswa" class="form-label">Pilih Siswa</label>
                            <select class="form-select @error('idsiswa') is-invalid @enderror" id="idsiswa" name="idsiswa" required>
                                <option value="" selected disabled>Pilih Siswa</option>
                                @foreach($availableSiswa as $siswa)
                                    <option value="{{ $siswa->idsiswa }}" {{ old('idsiswa') == $siswa->idsiswa ? 'selected' : '' }}>
                                        {{ $siswa->nama }} ({{ $siswa->id ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idsiswa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('walas.show', $idwalas) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
