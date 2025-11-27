<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Models\Article;

class ArticleService
{
    protected $repo;

    public function __construct(ArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get all published articles
     */
    public function getAllPublished()
    {
        return $this->repo->getAllPublished();
    }

    /**
     * Create new article
     */
    public function createArticle(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * Update article
     */
    public function updateArticle(Article $article, array $data)
    {
        return $this->repo->update($article, $data);
    }

    /**
     * Delete article
     */
    public function deleteArticle(Article $article)
    {
        return $this->repo->delete($article);
    }
}
