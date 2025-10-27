<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    /**
     * Get all published articles
     */
    public function getAllPublished()
    {
        return Article::where('is_published', true)
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    /**
     * Create new article
     */
    public function create(array $data)
    {
        return Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_published' => $data['is_published'] ?? false
        ]);
    }

    /**
     * Update article
     */
    public function update(Article $article, array $data)
    {
        $article->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_published' => $data['is_published'] ?? false
        ]);

        return $article;
    }

    /**
     * Delete article
     */
    public function delete(Article $article)
    {
        return $article->delete();
    }
}
