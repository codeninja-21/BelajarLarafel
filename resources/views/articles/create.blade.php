<!DOCTYPE html>
<html>
<head>
<title>Buat Artikel Baru</title>
</head>
<body>
<h1>Buat Artikel Baru</h1>

@if(session('error'))
<p>{{ session('error') }}</p>
@endif
@if($errors->any())
<div>
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('articles.store') }}">
@csrf
<div class="form-group">
    <label for="title">Judul Artikel:</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required>
</div>

<div class="form-group">
    <label for="content">Konten Artikel:</label>
    <textarea name="content" id="content" required>{{ old('content') }}</textarea>
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
        Publikasikan artikel
    </label>
</div>

<button type="submit">Simpan Artikel</button>
</form>

<div class="back-link">
    <a href="{{ route('landing') }}">← Kembali ke halaman utama</a>
</div>
</body>
</html>
