<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Models\BlogPost;
use Scanbox\Models\BlogCategory;
use Scanbox\Models\Setting;

class BlogController
{
    private BlogPost $blogPostModel;
    private BlogCategory $categoryModel;
    private Setting $settingModel;

    private const POSTS_PER_PAGE = 12;

    public function __construct()
    {
        $this->blogPostModel = new BlogPost();
        $this->categoryModel = new BlogCategory();
        $this->settingModel = new Setting();
    }

    /**
     * Lista articole blog cu paginare
     */
    public function index(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $posts = $this->blogPostModel->getPublished(self::POSTS_PER_PAGE, $offset);
        $totalPosts = $this->blogPostModel->countPublished();
        $totalPages = (int) ceil($totalPosts / self::POSTS_PER_PAGE);

        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAll();

        view('pages/blog/index', [
            'title' => 'Blog - Scanbox.ro',
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'settings' => $settings,
        ]);
    }

    /**
     * Afisare articol individual
     */
    public function show(string $slug): void
    {
        $post = $this->blogPostModel->getBySlug($slug);

        if ($post === null || $post['status'] !== 'published') {
            http_response_code(404);
            view('pages/404', [
                'title' => 'Articolul nu a fost găsit - Scanbox.ro',
            ]);
            return;
        }

        $relatedPosts = [];
        if (!empty($post['category_id'])) {
            $relatedPosts = $this->blogPostModel->getByCategory((int) $post['category_id']);
            // Exclude current post and limit to 3
            $relatedPosts = array_filter($relatedPosts, fn($p) => $p['id'] !== $post['id']);
            $relatedPosts = array_slice($relatedPosts, 0, 3);
        }

        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAll();

        view('pages/blog/single', [
            'title' => htmlspecialchars($post['title']) . ' - Blog Scanbox.ro',
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'categories' => $categories,
            'settings' => $settings,
        ]);
    }

    /**
     * Articole filtrate pe categorie
     */
    public function category(string $slug): void
    {
        $category = $this->categoryModel->getBySlug($slug);

        if ($category === null) {
            http_response_code(404);
            view('pages/404', [
                'title' => 'Categoria nu a fost găsită - Scanbox.ro',
            ]);
            return;
        }

        $posts = $this->blogPostModel->getByCategory((int) $category['id']);
        $totalPosts = count($posts);

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $totalPages = (int) ceil($totalPosts / self::POSTS_PER_PAGE);
        $offset = ($page - 1) * self::POSTS_PER_PAGE;
        $posts = array_slice($posts, $offset, self::POSTS_PER_PAGE);

        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAll();

        view('pages/blog/category', [
            'title' => htmlspecialchars($category['name'] ?? $category['name_ro'] ?? '') . ' - Blog Scanbox.ro',
            'category' => $category,
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'settings' => $settings,
        ]);
    }

    /**
     * Cautare articole blog
     */
    public function search(): void
    {
        $query = trim($_GET['q'] ?? '');

        if (empty($query)) {
            header('Location: /blog');
            exit;
        }

        $posts = $this->blogPostModel->search($query);
        $totalPosts = count($posts);

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $totalPages = (int) ceil($totalPosts / self::POSTS_PER_PAGE);
        $offset = ($page - 1) * self::POSTS_PER_PAGE;
        $posts = array_slice($posts, $offset, self::POSTS_PER_PAGE);

        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAll();

        view('pages/blog/search', [
            'title' => 'Căutare: ' . htmlspecialchars($query) . ' - Blog Scanbox.ro',
            'query' => $query,
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'settings' => $settings,
        ]);
    }
}
