<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Models\Message;
use Scanbox\Models\Project;
use Scanbox\Models\BlogPost;
use Scanbox\Models\Gallery;
use Scanbox\Models\GalleryItem;
use Scanbox\Models\Testimonial;
use Scanbox\Models\ClientLogo;
use Scanbox\Models\Setting;
use Scanbox\Models\PricingPackage;
use Scanbox\Models\Category;
use Scanbox\Models\Service;
use Scanbox\Core\ImageHandler;

class AdminController
{
    private Database $db;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Dashboard - pagina principala admin
     */
    public function dashboard(): void
    {
        $db = Database::getInstance();

        // Statistici directe (modelele nu au countAll/countByStatus)
        $stats = [
            'unread_messages' => $db->count('messages', "status = 'new'"),
            'total_projects' => $db->count('portfolio_projects'),
            'total_posts' => $db->count('blog_posts'),
            'total_gallery_images' => $db->count('gallery_items'),
        ];

        // Mesaje recente
        $recent_messages = $db->fetchAll(
            "SELECT * FROM messages ORDER BY created_at DESC LIMIT 5"
        );

        // Activitate recenta
        $recentRows = $db->fetchAll(
            "SELECT al.*, u.name as user_name
             FROM activity_log al
             LEFT JOIN admins u ON al.admin_id = u.id
             ORDER BY al.created_at DESC
             LIMIT 10"
        );

        $recent_activity = array_map(function ($row) {
            return [
                'action' => $row['action'] ?? '',
                'badge_class' => match ($row['action'] ?? '') {
                    'login' => 'badge-green',
                    'logout' => 'badge-gray',
                    'blog_create', 'portfolio_create' => 'badge-blue',
                    'blog_update', 'portfolio_update' => 'badge-orange',
                    'blog_delete', 'portfolio_delete' => 'badge-red',
                    default => 'badge-gray',
                },
                'item' => $row['details'] ?? ($row['entity_type'] ?? '-'),
                'date' => isset($row['created_at']) ? date('d.m.Y H:i', strtotime($row['created_at'])) : '-',
            ];
        }, $recentRows);

        view('admin/dashboard', [
            'title' => 'Dashboard - Admin Scanbox.ro',
            'stats' => $stats,
            'recent_messages' => $recent_messages,
            'recent_activity' => $recent_activity,
        ], null);
    }

    /**
     * Lista articole blog in admin
     */
    public function blog(): void
    {
        $blogPostModel = new BlogPost();
        $status = $_GET['status'] ?? null;

        if ($status && in_array($status, ['published', 'draft', 'archived'], true)) {
            $posts = $blogPostModel->getByStatus($status);
        } else {
            $posts = $blogPostModel->getAll();
        }

        view('admin/blog/list', [
            'title' => 'Articole Blog - Admin Scanbox.ro',
            'posts' => $posts,
            'currentStatus' => $status,
        ], null);
    }

    /**
     * Formular articol blog nou (GET) / Salvare (POST)
     */
    public function blogNew(): void
    {
        $blogPostModel = new BlogPost();
        $db = Database::getInstance();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => $this->generateSlug($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'excerpt' => trim($_POST['excerpt'] ?? ''),
                'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'thumbnail' => trim($_POST['thumbnail'] ?? ''),
                'meta_title' => trim($_POST['meta_title'] ?? ''),
                'meta_description' => trim($_POST['meta_description'] ?? ''),
                'status' => $_POST['status'] ?? 'draft',
                'author_id' => $_SESSION['user_id'],
                'published_at' => ($_POST['status'] ?? 'draft') === 'published' ? date('Y-m-d H:i:s') : null,
            ];

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                header('Location: /admin/blog/new');
                exit;
            }

            // Upload imagine thumbnail daca exista
            if (!empty($_FILES['thumbnail_file']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail_file'], 'blog');
                if ($uploadResult !== false) {
                    $data['thumbnail'] = $uploadResult['file_path'];
                }
            }

            $postId = $blogPostModel->create($data);
            $this->logActivity('blog_create', "Articol blog creat: {$data['title']} (ID: {$postId})");

            $_SESSION['flash_success'] = 'Articolul a fost creat cu succes.';
            header('Location: /admin/blog');
            exit;
        }

        $categories = $db->fetchAll("SELECT * FROM blog_categories ORDER BY name ASC");
        $csrfToken = $this->generateCsrf();

        view('admin/blog/edit', [
            'title' => 'Articol Nou - Admin Scanbox.ro',
            'post' => null,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => '/admin/blog/new',
        ], null);
    }

    /**
     * Editare articol blog (GET) / Actualizare (POST)
     */
    public function blogEdit(int $id): void
    {
        $blogPostModel = new BlogPost();
        $db = Database::getInstance();

        $post = $blogPostModel->getById($id);
        if ($post === null) {
            http_response_code(404);
            $_SESSION['flash_error'] = 'Articolul nu a fost găsit.';
            header('Location: /admin/blog');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => !empty($_POST['slug']) ? $this->generateSlug($_POST['slug']) : $this->generateSlug($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'excerpt' => trim($_POST['excerpt'] ?? ''),
                'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'thumbnail' => trim($_POST['thumbnail'] ?? $post['thumbnail']),
                'meta_title' => trim($_POST['meta_title'] ?? ''),
                'meta_description' => trim($_POST['meta_description'] ?? ''),
                'status' => $_POST['status'] ?? $post['status'],
            ];

            // Setare data publicarii daca se publica acum
            if ($data['status'] === 'published' && $post['status'] !== 'published') {
                $data['published_at'] = date('Y-m-d H:i:s');
            }

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                header("Location: /admin/blog/edit/{$id}");
                exit;
            }

            // Upload imagine thumbnail daca exista
            if (!empty($_FILES['thumbnail_file']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail_file'], 'blog');
                if ($uploadResult !== false) {
                    $data['thumbnail'] = $uploadResult['file_path'];
                }
            }

            $blogPostModel->update($id, $data);
            $this->logActivity('blog_update', "Articol blog actualizat: {$data['title']} (ID: {$id})");

            $_SESSION['flash_success'] = 'Articolul a fost actualizat cu succes.';
            header('Location: /admin/blog');
            exit;
        }

        $categories = $db->fetchAll("SELECT * FROM blog_categories ORDER BY name ASC");
        $csrfToken = $this->generateCsrf();

        view('admin/blog/edit', [
            'title' => 'Editare Articol - Admin Scanbox.ro',
            'post' => $post,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => "/admin/blog/edit/{$id}",
        ], null);
    }

    /**
     * Stergere articol blog (POST)
     */
    public function blogDelete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/blog');
            exit;
        }

        $this->validateCsrf();

        $blogPostModel = new BlogPost();
        $post = $blogPostModel->getById($id);

        if ($post !== null) {
            $blogPostModel->delete($id);
            $this->logActivity('blog_delete', "Articol blog șters: {$post['title']} (ID: {$id})");
            $_SESSION['flash_success'] = 'Articolul a fost șters.';
        } else {
            $_SESSION['flash_error'] = 'Articolul nu a fost găsit.';
        }

        header('Location: /admin/blog');
        exit;
    }

    /**
     * Gestionare galerie in admin
     */
    public function gallery(): void
    {
        $galleryModel = new Gallery();
        $db = Database::getInstance();

        // Handle POST actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $postAction = $_POST['action'] ?? '';
            $galleryId = (int) ($_POST['gallery_id'] ?? $_POST['id'] ?? 0);

            switch ($postAction) {
                case 'create_gallery':
                    $name = trim($_POST['name'] ?? '');
                    $slug = trim($_POST['slug'] ?? '') ?: $this->generateSlug($name);
                    $page = $_POST['page'] ?? null;
                    if (!empty($name)) {
                        $galleryModel->create(['name' => $name, 'slug' => $slug, 'page' => $page]);
                        $this->logActivity('gallery_create', "Galerie creată: {$name}");
                        $_SESSION['flash_success'] = 'Galeria a fost creată.';
                    }
                    header('Location: /admin/gallery');
                    exit;

                case 'delete_gallery':
                    if ($galleryId > 0) {
                        $gallery = $galleryModel->getById($galleryId);
                        if ($gallery) {
                            $db->delete('gallery_items', 'gallery_id = ?', [$galleryId]);
                            $galleryModel->delete($galleryId);
                            $this->logActivity('gallery_delete', "Galerie ștearsă: " . ($gallery['name'] ?? ''));
                            $_SESSION['flash_success'] = 'Galeria a fost ștearsă.';
                        }
                    }
                    header('Location: /admin/gallery');
                    exit;

                case 'upload_image':
                    if ($galleryId > 0 && !empty($_FILES['images']['name'][0])) {
                        $imageHandler = new ImageHandler();
                        $galleryItemModel = new GalleryItem();
                        $uploadCount = 0;
                        $currentMax = (int) ($db->fetch(
                            "SELECT MAX(sort_order) as mx FROM gallery_items WHERE gallery_id = ?",
                            [$galleryId]
                        )['mx'] ?? 0);

                        $fileCount = count($_FILES['images']['name']);
                        for ($i = 0; $i < $fileCount; $i++) {
                            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
                            $file = [
                                'name' => $_FILES['images']['name'][$i],
                                'type' => $_FILES['images']['type'][$i],
                                'tmp_name' => $_FILES['images']['tmp_name'][$i],
                                'error' => $_FILES['images']['error'][$i],
                                'size' => $_FILES['images']['size'][$i],
                            ];
                            $uploadResult = $imageHandler->upload($file, 'gallery');
                            if ($uploadResult !== false) {
                                $currentMax++;
                                $galleryItemModel->create([
                                    'gallery_id' => $galleryId,
                                    'file_path' => $uploadResult['file_path'],
                                    'thumbnail_path' => $uploadResult['thumbnail_path'] ?? null,
                                    'alt_text' => pathinfo($file['name'], PATHINFO_FILENAME),
                                    'sort_order' => $currentMax,
                                ]);
                                $uploadCount++;
                            }
                        }
                        $_SESSION['flash_success'] = "{$uploadCount} imagine/imagini încărcate.";
                    } else {
                        $_SESSION['flash_error'] = 'Nu ați selectat nicio imagine.';
                    }
                    header("Location: /admin/gallery?action=manage&id={$galleryId}");
                    exit;

                case 'delete_image':
                    $itemId = (int) ($_POST['item_id'] ?? 0);
                    if ($itemId > 0) {
                        $galleryItemModel = new GalleryItem();
                        $galleryItemModel->delete($itemId);
                        $_SESSION['flash_success'] = 'Imaginea a fost ștearsă.';
                    }
                    header("Location: /admin/gallery?action=manage&id={$galleryId}");
                    exit;
            }
        }

        // Gestionare galerie individuala
        $action = $_GET['action'] ?? '';
        if ($action === 'manage' && !empty($_GET['id'])) {
            $galleryId = (int) $_GET['id'];
            $gallery = $galleryModel->getById($galleryId);

            if ($gallery === null) {
                $_SESSION['flash_error'] = 'Galeria nu a fost găsită.';
                header('Location: /admin/gallery');
                exit;
            }

            $galleryItemModel = new GalleryItem();
            $items = $galleryItemModel->getByGallery($galleryId);

            view('admin/gallery/upload', [
                'title' => 'Gestionare Galerie - Admin Scanbox.ro',
                'gallery' => $gallery,
                'items' => $items,
                'csrf_token' => $this->generateCsrf(),
            ], null);
            return;
        }

        $galleries = $galleryModel->getAll();

        // Adaugam item_count direct pe fiecare galerie (flat, cum asteapta view-ul)
        foreach ($galleries as &$gallery) {
            $gallery['item_count'] = $db->count('gallery_items', 'gallery_id = ?', [(int) $gallery['id']]);
        }
        unset($gallery);

        view('admin/gallery/list', [
            'title' => 'Galerie - Admin Scanbox.ro',
            'galleries' => $galleries,
            'csrf_token' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Upload imagine in galerie (POST)
     */
    public function galleryUpload(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/gallery');
            exit;
        }

        $this->validateCsrf();

        $galleryId = (int) ($_POST['gallery_id'] ?? 0);
        if ($galleryId <= 0) {
            $_SESSION['flash_error'] = 'Galeria nu a fost specificată.';
            header('Location: /admin/gallery');
            exit;
        }

        $galleryModel = new Gallery();
        $gallery = $galleryModel->getById($galleryId);
        if ($gallery === null) {
            $_SESSION['flash_error'] = 'Galeria nu a fost găsită.';
            header('Location: /admin/gallery');
            exit;
        }

        if (empty($_FILES['images']['name'][0])) {
            $_SESSION['flash_error'] = 'Nu ați selectat nicio imagine.';
            header('Location: /admin/gallery');
            exit;
        }

        $imageHandler = new ImageHandler();
        $galleryItemModel = new GalleryItem();
        $uploadCount = 0;

        $fileCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $_FILES['images']['name'][$i],
                'type' => $_FILES['images']['type'][$i],
                'tmp_name' => $_FILES['images']['tmp_name'][$i],
                'error' => $_FILES['images']['error'][$i],
                'size' => $_FILES['images']['size'][$i],
            ];

            $uploadResult = $imageHandler->upload($file, 'gallery');
            if ($uploadResult !== false) {
                $currentMax = (int) (Database::getInstance()->fetch(
                    "SELECT MAX(sort_order) as mx FROM gallery_items WHERE gallery_id = ?",
                    [$galleryId]
                )['mx'] ?? 0);
                $galleryItemModel->create([
                    'gallery_id' => $galleryId,
                    'file_path' => $uploadResult['file_path'],
                    'thumbnail_path' => $uploadResult['thumbnail_path'] ?? null,
                    'alt_text' => pathinfo($file['name'], PATHINFO_FILENAME),
                    'sort_order' => $currentMax + 1,
                ]);
                $uploadCount++;
            }
        }

        $this->logActivity('gallery_upload', "Încărcate {$uploadCount} imagini în galeria: {$gallery['name']}");
        $_SESSION['flash_success'] = "{$uploadCount} imagine/imagini încărcate cu succes.";
        header('Location: /admin/gallery');
        exit;
    }

    /**
     * Gestionare portofoliu in admin (lista, edit, create, update, delete)
     */
    public function portfolio(): void
    {
        $projectModel = new Project();
        $db = Database::getInstance();

        // Handle POST actions (create, update, delete)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $postAction = $_POST['action'] ?? '';
            $projectId = (int) ($_POST['id'] ?? 0);

            switch ($postAction) {
                case 'create':
                    $data = [
                        'title' => trim($_POST['title'] ?? ''),
                        'slug' => !empty($_POST['slug']) ? $this->generateSlug($_POST['slug']) : $this->generateSlug($_POST['title'] ?? ''),
                        'description' => $_POST['description'] ?? '',
                        'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                        'city' => trim($_POST['city'] ?? ''),
                        'address' => trim($_POST['address'] ?? ''),
                        'lat' => !empty($_POST['latitude']) ? (float) $_POST['latitude'] : null,
                        'lng' => !empty($_POST['longitude']) ? (float) $_POST['longitude'] : null,
                        'matterport_url' => trim($_POST['matterport_url'] ?? ''),
                        'completion_date' => !empty($_POST['completed_at']) ? $_POST['completed_at'] : null,
                        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                    ];

                    if (empty($data['title'])) {
                        $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                        header('Location: /admin/portfolio?action=edit');
                        exit;
                    }

                    // Upload thumbnail
                    if (!empty($_FILES['thumbnail_file']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['thumbnail_file'], 'portfolio');
                        if ($uploadResult !== false) {
                            $data['thumbnail'] = $uploadResult['file_path'];
                        }
                    } elseif (!empty($_POST['thumbnail'])) {
                        $data['thumbnail'] = trim($_POST['thumbnail']);
                    }

                    $newId = $projectModel->create($data);
                    $this->logActivity('portfolio_create', "Proiect creat: {$data['title']} (ID: {$newId})");
                    $_SESSION['flash_success'] = 'Proiectul a fost creat cu succes.';
                    header('Location: /admin/portfolio');
                    exit;

                case 'update':
                    if ($projectId <= 0) break;
                    $existing = $projectModel->getById($projectId);
                    if (!$existing) {
                        $_SESSION['flash_error'] = 'Proiectul nu a fost găsit.';
                        header('Location: /admin/portfolio');
                        exit;
                    }

                    $data = [
                        'title' => trim($_POST['title'] ?? ''),
                        'slug' => !empty($_POST['slug']) ? $this->generateSlug($_POST['slug']) : $this->generateSlug($_POST['title'] ?? ''),
                        'description' => $_POST['description'] ?? '',
                        'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                        'city' => trim($_POST['city'] ?? ''),
                        'address' => trim($_POST['address'] ?? ''),
                        'lat' => !empty($_POST['latitude']) ? (float) $_POST['latitude'] : null,
                        'lng' => !empty($_POST['longitude']) ? (float) $_POST['longitude'] : null,
                        'matterport_url' => trim($_POST['matterport_url'] ?? ''),
                        'completion_date' => !empty($_POST['completed_at']) ? $_POST['completed_at'] : null,
                        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                    ];

                    if (empty($data['title'])) {
                        $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                        header("Location: /admin/portfolio?action=edit&id={$projectId}");
                        exit;
                    }

                    // Upload thumbnail daca exista fisier nou
                    if (!empty($_FILES['thumbnail_file']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['thumbnail_file'], 'portfolio');
                        if ($uploadResult !== false) {
                            $data['thumbnail'] = $uploadResult['file_path'];
                        }
                    } elseif (!empty($_POST['thumbnail'])) {
                        $data['thumbnail'] = trim($_POST['thumbnail']);
                    }

                    $projectModel->update($projectId, $data);
                    $this->logActivity('portfolio_update', "Proiect actualizat: {$data['title']} (ID: {$projectId})");
                    $_SESSION['flash_success'] = 'Proiectul a fost actualizat cu succes.';
                    header('Location: /admin/portfolio');
                    exit;

                case 'delete':
                    if ($projectId > 0) {
                        $existing = $projectModel->getById($projectId);
                        if ($existing) {
                            $projectModel->delete($projectId);
                            $this->logActivity('portfolio_delete', "Proiect șters: {$existing['title']} (ID: {$projectId})");
                            $_SESSION['flash_success'] = 'Proiectul a fost șters.';
                        }
                    }
                    header('Location: /admin/portfolio');
                    exit;
            }
        }

        // Handle GET actions
        $action = $_GET['action'] ?? '';

        // Edit/New form
        if ($action === 'edit') {
            $editId = (int) ($_GET['id'] ?? 0);
            $project = $editId > 0 ? $projectModel->getById($editId) : null;

            // Map DB column names to what the view expects
            if ($project) {
                $project['latitude'] = $project['lat'] ?? '';
                $project['longitude'] = $project['lng'] ?? '';
                $project['completed_at'] = $project['completion_date'] ?? '';
            }

            $categories = $db->fetchAll("SELECT id, name_ro, slug FROM portfolio_categories ORDER BY sort_order ASC, id ASC");

            view('admin/portfolio/edit', [
                'title' => $project ? 'Editare Proiect - Admin Scanbox.ro' : 'Proiect Nou - Admin Scanbox.ro',
                'project' => $project,
                'categories' => $categories,
                'csrf_token' => $this->generateCsrf(),
            ], null);
            return;
        }

        // List view
        $categoryFilter = $_GET['category'] ?? null;
        if ($categoryFilter) {
            $projects = $db->fetchAll(
                "SELECT p.*, c.name_ro as category_name
                 FROM portfolio_projects p
                 LEFT JOIN portfolio_categories c ON p.category_id = c.id
                 WHERE p.category_id = ?
                 ORDER BY p.sort_order ASC, p.id DESC",
                [(int) $categoryFilter]
            );
        } else {
            $projects = $db->fetchAll(
                "SELECT p.*, c.name_ro as category_name
                 FROM portfolio_projects p
                 LEFT JOIN portfolio_categories c ON p.category_id = c.id
                 ORDER BY p.sort_order ASC, p.id DESC"
            );
        }

        $categories = $db->fetchAll("SELECT id, name_ro, slug FROM portfolio_categories ORDER BY sort_order ASC, id ASC");

        view('admin/portfolio/list', [
            'title' => 'Portofoliu - Admin Scanbox.ro',
            'projects' => $projects,
            'categories' => $categories,
            'current_category' => $categoryFilter,
            'csrf_token' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Gestionare testimoniale
     */
    public function testimonials(): void
    {
        $testimonialModel = new Testimonial();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create':
                    $data = [
                        'name' => trim($_POST['name'] ?? ''),
                        'position' => trim($_POST['position'] ?? ''),
                        'company' => trim($_POST['company'] ?? ''),
                        'content' => trim($_POST['content'] ?? ''),
                        'rating' => (int) ($_POST['rating'] ?? 5),
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                    ];

                    if (!empty($_FILES['avatar']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['avatar'], 'testimonials');
                        if ($uploadResult !== false) {
                            $data['avatar'] = $uploadResult['file_path'];
                        }
                    }

                    $testimonialModel->create($data);
                    $this->logActivity('testimonial_create', "Testimonial creat: {$data['name']}");
                    $_SESSION['flash_success'] = 'Testimonialul a fost adăugat.';
                    break;

                case 'update':
                    $id = (int) ($_POST['id'] ?? 0);
                    $data = [
                        'name' => trim($_POST['name'] ?? ''),
                        'position' => trim($_POST['position'] ?? ''),
                        'company' => trim($_POST['company'] ?? ''),
                        'content' => trim($_POST['content'] ?? ''),
                        'rating' => (int) ($_POST['rating'] ?? 5),
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                    ];

                    if (!empty($_FILES['avatar']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['avatar'], 'testimonials');
                        if ($uploadResult !== false) {
                            $data['avatar'] = $uploadResult['file_path'];
                        }
                    }

                    $testimonialModel->update($id, $data);
                    $this->logActivity('testimonial_update', "Testimonial actualizat (ID: {$id})");
                    $_SESSION['flash_success'] = 'Testimonialul a fost actualizat.';
                    break;

                case 'delete':
                    $id = (int) ($_POST['id'] ?? 0);
                    $testimonialModel->delete($id);
                    $this->logActivity('testimonial_delete', "Testimonial șters (ID: {$id})");
                    $_SESSION['flash_success'] = 'Testimonialul a fost șters.';
                    break;
            }

            header('Location: /admin/testimonials');
            exit;
        }

        $testimonials = $testimonialModel->getAll();

        view('admin/testimonials/manage', [
            'title' => 'Testimoniale - Admin Scanbox.ro',
            'testimonials' => $testimonials,
            'csrfToken' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Gestionare logo-uri clienti
     */
    public function clients(): void
    {
        $clientLogoModel = new ClientLogo();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create':
                    $data = [
                        'name' => trim($_POST['name'] ?? ''),
                        'website_url' => trim($_POST['website_url'] ?? ''),
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                        'sort_order' => (int) ($_POST['sort_order'] ?? 0),
                    ];

                    if (!empty($_FILES['logo']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['logo'], 'clients');
                        if ($uploadResult !== false) {
                            $data['logo_path'] = $uploadResult['file_path'];
                        }
                    }

                    if (empty($data['name']) || empty($data['logo_path'] ?? '')) {
                        $_SESSION['flash_error'] = 'Numele și logo-ul sunt obligatorii.';
                    } else {
                        $clientLogoModel->create($data);
                        $this->logActivity('client_create', "Client adăugat: {$data['name']}");
                        $_SESSION['flash_success'] = 'Clientul a fost adăugat.';
                    }
                    break;

                case 'update':
                    $id = (int) ($_POST['id'] ?? 0);
                    $data = [
                        'name' => trim($_POST['name'] ?? ''),
                        'website_url' => trim($_POST['website_url'] ?? ''),
                        'is_active' => isset($_POST['is_active']) ? 1 : 0,
                        'sort_order' => (int) ($_POST['sort_order'] ?? 0),
                    ];

                    if (!empty($_FILES['logo']['name'])) {
                        $imageHandler = new ImageHandler();
                        $uploadResult = $imageHandler->upload($_FILES['logo'], 'clients');
                        if ($uploadResult !== false) {
                            $data['logo_path'] = $uploadResult['file_path'];
                        }
                    }

                    $clientLogoModel->update($id, $data);
                    $this->logActivity('client_update', "Client actualizat (ID: {$id})");
                    $_SESSION['flash_success'] = 'Clientul a fost actualizat.';
                    break;

                case 'delete':
                    $id = (int) ($_POST['id'] ?? 0);
                    $clientLogoModel->delete($id);
                    $this->logActivity('client_delete', "Client șters (ID: {$id})");
                    $_SESSION['flash_success'] = 'Clientul a fost șters.';
                    break;
            }

            header('Location: /admin/clients');
            exit;
        }

        $clients = $clientLogoModel->getAll();

        view('admin/clients/manage', [
            'title' => 'Clienți - Admin Scanbox.ro',
            'clients' => $clients,
            'csrfToken' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Lista mesaje in admin
     */
    public function messages(): void
    {
        $messageModel = new Message();
        $status = $_GET['status'] ?? null;

        if ($status && in_array($status, ['new', 'read', 'replied', 'archived'], true)) {
            $messages = $messageModel->getByStatus($status);
        } else {
            $messages = $messageModel->getAll();
        }

        view('admin/messages/list', [
            'title' => 'Mesaje - Admin Scanbox.ro',
            'messages' => $messages,
            'currentStatus' => $status,
        ], null);
    }

    /**
     * Vizualizare mesaj individual, marcare ca citit
     */
    public function messageView(int $id): void
    {
        $messageModel = new Message();
        $message = $messageModel->getById($id);

        if ($message === null) {
            $_SESSION['flash_error'] = 'Mesajul nu a fost găsit.';
            header('Location: /admin/messages');
            exit;
        }

        // Marcare ca citit daca este nou
        if ($message['status'] === 'new') {
            $messageModel->updateStatus($id, 'read');
            $message['status'] = 'read';
        }

        view('admin/messages/view', [
            'title' => 'Mesaj de la ' . htmlspecialchars($message['name']) . ' - Admin Scanbox.ro',
            'message' => $message,
            'csrfToken' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Gestionare setari site
     */
    public function settings(): void
    {
        $settingModel = new Setting();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $settings = $_POST['settings'] ?? [];

            foreach ($settings as $key => $value) {
                $settingModel->set($key, trim($value));
            }

            $this->logActivity('settings_update', 'Setări site actualizate');
            $_SESSION['flash_success'] = 'Setările au fost actualizate cu succes.';
            header('Location: /admin/settings');
            exit;
        }

        $settings = $settingModel->getAllGrouped();

        view('admin/settings/index', [
            'title' => 'Setări - Admin Scanbox.ro',
            'settings' => $settings,
            'csrfToken' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Gestionare pachete de preturi
     */
    public function pricing(): void
    {
        $pricingModel = new PricingPackage();
        $serviceModel = new Service();

        $packages = $pricingModel->getAllGrouped();
        $services = $serviceModel->getAll();

        view('admin/pricing/manage', [
            'title' => 'Prețuri - Admin Scanbox.ro',
            'packages' => $packages,
            'services' => $services,
            'csrfToken' => $this->generateCsrf(),
        ], null);
    }

    /**
     * Validare token CSRF
     */
    private function validateCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Token de securitate invalid.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin'));
            exit;
        }
    }

    /**
     * Generare token CSRF
     */
    private function generateCsrf(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    /**
     * Generare slug din titlu
     */
    private function generateSlug(string $title): string
    {
        $slug = mb_strtolower($title, 'UTF-8');

        // Inlocuire diacritice romanesti
        $diacritice = [
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
            'Ă' => 'a', 'Â' => 'a', 'Î' => 'i', 'Ș' => 's', 'Ț' => 't',
        ];
        $slug = strtr($slug, $diacritice);

        // Pastrare doar litere, cifre si cratime
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Inregistrare activitate in log
     */
    private function logActivity(string $action, string $description): void
    {
        try {
            $db = Database::getInstance();
            $db->insert('activity_log', [
                'admin_id' => $_SESSION['user_id'],
                'action' => $action,
                'entity_type' => 'admin',
                'details' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Eroare logare activitate: ' . $e->getMessage());
        }
    }
}
