@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Wali Kelas Baru</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('walas.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="idguru" class="form-label">Guru</label>
                            <select class="form-select @error('idguru') is-invalid @enderror" id="idguru" name="idguru" required>
                                <option value="" selected disabled>Pilih Guru</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->idguru }}" {{ old('idguru') == $guru->idguru ? 'selected' : '' }}>
                                        {{ $guru->nama }} ({{ $guru->mapel }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idguru')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenjang" class="form-label">Jenjang</label>
                                <select class="form-select @error('jenjang') is-invalid @enderror" id="jenjang" name="jenjang" required>
                                    <option value="" selected disabled>Pilih Jenjang</option>
                                    <option value="X" {{ old('jenjang') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('jenjang') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('jenjang') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                                @error('jenjang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="namakelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control @error('namakelas') is-invalid @enderror" 
                                    id="namakelas" name="namakelas" value="{{ old('namakelas') }}" required>
                                @error('namakelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tahunajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control @error('tahunajaran') is-invalid @enderror" 
                                id="tahunajaran" name="tahunajaran" value="{{ old('tahunajaran', date('Y') . '/' . (date('Y') + 1)) }}" required>
                            <small class="form-text text-muted">Format: YYYY/YYYY</small>
                            @error('tahunajaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('walas.index') }}" class="btn btn-secondary me-md-2">
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
@endsection
