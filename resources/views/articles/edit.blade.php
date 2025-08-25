<!DOCTYPE html>
<html>
<head>
<title>Edit Artikel</title>
</head>
<body>
<h1>Edit Artikel</h1>

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

<form method="POST" action="{{ route('articles.update', $article) }}">
@csrf
@method('PUT')
<div class="form-group">
    <label for="title">Judul Artikel:</label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required>
</div>

<div class="form-group">
    <label for="content">Konten Artikel:</label>
    <textarea name="content" id="content" required>{{ old('content', $article->content) }}</textarea>
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
        Publikasikan artikel
    </label>
</div>

<button type="submit">Update Artikel</button>
</form>

<div class="back-link">
    <a href="{{ route('articles.show', $article) }}">← Kembali ke artikel</a> |
    <a href="{{ route('landing') }}">Halaman utama</a>
</div>
</body>
</html>
