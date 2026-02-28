<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Models\BlogPost;
use Scanbox\Models\Service;
use Scanbox\Models\Setting;

class SearchController
{
    private BlogPost $blogPostModel;
    private Service $serviceModel;
    private Setting $settingModel;

    public function __construct()
    {
        $this->blogPostModel = new BlogPost();
        $this->serviceModel = new Service();
        $this->settingModel = new Setting();
    }

    /**
     * Cautare globala in articole si servicii
     */
    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');

        if (empty($query)) {
            if ($this->isAjax()) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'success' => false,
                    'message' => 'Introduceți un termen de căutare.',
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            header('Location: /');
            exit;
        }

        $sanitizedQuery = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

        // Cautare in articole blog
        $blogResults = $this->blogPostModel->search($query, 10, 0);

        // Cautare in servicii
        $serviceResults = $this->serviceModel->search($query);

        $totalResults = count($blogResults) + count($serviceResults);

        // Raspuns AJAX (JSON)
        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => true,
                'query' => $sanitizedQuery,
                'totalResults' => $totalResults,
                'blog' => array_map(function (array $post): array {
                    return [
                        'id' => $post['id'],
                        'title' => $post['title'],
                        'slug' => $post['slug'],
                        'excerpt' => $post['excerpt'] ?? mb_substr(strip_tags($post['content'] ?? ''), 0, 150) . '...',
                        'thumbnail' => $post['thumbnail'] ?? null,
                        'published_at' => $post['published_at'] ?? $post['created_at'],
                        'url' => '/blog/' . $post['slug'],
                    ];
                }, $blogResults),
                'services' => array_map(function (array $service): array {
                    return [
                        'id' => $service['id'],
                        'title' => $service['title'],
                        'slug' => $service['slug'],
                        'description' => $service['short_description'] ?? mb_substr(strip_tags($service['description'] ?? ''), 0, 150) . '...',
                        'icon' => $service['icon'] ?? null,
                        'url' => '/servicii/' . $service['slug'],
                    ];
                }, $serviceResults),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Raspuns pagina completa
        $settings = $this->settingModel->getAll();

        view('pages/search', [
            'title' => 'Căutare: ' . $sanitizedQuery . ' - Scanbox.ro',
            'query' => $query,
            'blogResults' => $blogResults,
            'serviceResults' => $serviceResults,
            'totalResults' => $totalResults,
            'settings' => $settings,
        ]);
    }

    /**
     * Verifica daca cererea este AJAX
     */
    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
