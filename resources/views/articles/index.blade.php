<!DOCTYPE html>
<html>
<head>
<title>Semua Artikel</title>
</head>
<body>
<div class="header">
    <h1>Semua Artikel</h1>
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif
</div>

@if($articles->count() > 0)
    @foreach($articles as $article)
    <div class="article-item">
        <a href="{{ route('articles.show', $article->slug) }}" class="article-title">
            {{ $article->title }}
        </a>
        <div class="article-excerpt">
            {{ $article->excerpt }}
        </div>
        <div class="article-date">
            Dipublikasikan: {{ $article->created_at->format('d M Y') }}
        </div>
    </div>
    @endforeach
@else
    <p>Belum ada artikel yang dipublikasikan.</p>
@endif

<div class="back-link">
    <a href="{{ route('landing') }}">← Kembali ke halaman utama</a>
</div>
</body>
</html>
