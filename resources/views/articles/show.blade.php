<!DOCTYPE html>
<html>
<head>
<title>{{ $article->title }}</title>
</head>
<body>
<div class="article-header">
    <h1 class="article-title">{{ $article->title }}</h1>
    <div class="article-meta">
        Dipublikasikan: {{ $article->created_at->format('d M Y H:i') }}
    </div>
</div>

<div class="article-content">
    {!! nl2br(e($article->content)) !!}
</div>

@if(session('admin_id'))
<div class="admin-actions">
    <strong>Admin Actions:</strong>
    <a href="{{ route('articles.edit', $article) }}">Edit Artikel</a>
    <form method="POST" action="{{ route('articles.destroy', $article) }}" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</button>
    </form>
</div>
@endif

<div class="back-link">
    <a href="{{ route('landing') }}">← Kembali ke halaman utama</a> |
    <a href="{{ route('articles.index') }}">Lihat semua artikel</a>
</div>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif
</body>
</html>
