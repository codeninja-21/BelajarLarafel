<!DOCTYPE html>
<html>
<head>
<title>Landing</title>
</head>
<body>
<div class="header">
    <h2>Ini Halaman Landing Page</h2>
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif
    @if(session('error'))
    <p>{{ session('error') }}</p>
    @endif
</div>

<div class="auth-buttons">
    <a href="{{ url('/login') }}">
    <button>Login disini</button>
    </a>
    <a href="{{ url('/register') }}">
    <button>Register disini</button>
    </a>
    @if(session('admin_id'))
    <a href="{{ route('articles.create') }}">
    <button>Buat Artikel</button>
    </a>
    @endif
</div>

<div class="articles-section">
    <h3>Artikel Terbaru</h3>
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
        <p><a href="{{ route('articles.index') }}">Lihat semua artikel →</a></p>
    @else
        <p>Belum ada artikel yang dipublikasikan.</p>
    @endif
</div>
</body>
</html>
