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

        $messageModel = new Message();
        $projectModel = new Project();
        $blogPostModel = new BlogPost();
        $galleryItemModel = new GalleryItem();

        // Statistici
        $unreadMessages = $messageModel->countByStatus('new');
        $totalProjects = $projectModel->countAll();
        $totalPosts = $blogPostModel->countAll();
        $totalGalleryImages = $galleryItemModel->countAll();

        // Mesaje recente
        $recentMessages = $messageModel->getRecent(5);

        // Activitate recenta
        $recentActivity = $db->fetchAll(
            "SELECT al.*, u.name as user_name
             FROM activity_log al
             LEFT JOIN users u ON al.user_id = u.id
             ORDER BY al.created_at DESC
             LIMIT 10"
        );

        view('admin/dashboard', [
            'title' => 'Dashboard - Admin Scanbox.ro',
            'unreadMessages' => $unreadMessages,
            'totalProjects' => $totalProjects,
            'totalPosts' => $totalPosts,
            'totalGalleryImages' => $totalGalleryImages,
            'recentMessages' => $recentMessages,
            'recentActivity' => $recentActivity,
        ]);
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

        view('admin/blog/index', [
            'title' => 'Articole Blog - Admin Scanbox.ro',
            'posts' => $posts,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Formular articol blog nou (GET) / Salvare (POST)
     */
    public function blogNew(): void
    {
        $blogPostModel = new BlogPost();
        $categoryModel = new Category();

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
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            $postId = $blogPostModel->create($data);
            $this->logActivity('blog_create', "Articol blog creat: {$data['title']} (ID: {$postId})");

            $_SESSION['flash_success'] = 'Articolul a fost creat cu succes.';
            header('Location: /admin/blog');
            exit;
        }

        $categories = $categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/blog/form', [
            'title' => 'Articol Nou - Admin Scanbox.ro',
            'post' => null,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => '/admin/blog/new',
        ]);
    }

    /**
     * Editare articol blog (GET) / Actualizare (POST)
     */
    public function blogEdit(int $id): void
    {
        $blogPostModel = new BlogPost();
        $categoryModel = new Category();

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
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            $blogPostModel->update($id, $data);
            $this->logActivity('blog_update', "Articol blog actualizat: {$data['title']} (ID: {$id})");

            $_SESSION['flash_success'] = 'Articolul a fost actualizat cu succes.';
            header('Location: /admin/blog');
            exit;
        }

        $categories = $categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/blog/form', [
            'title' => 'Editare Articol - Admin Scanbox.ro',
            'post' => $post,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => "/admin/blog/edit/{$id}",
        ]);
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
        $galleryItemModel = new GalleryItem();

        $galleries = $galleryModel->getAll();
        $galleriesWithItems = [];

        foreach ($galleries as $gallery) {
            $items = $galleryItemModel->getByGalleryId((int) $gallery['id']);
            $galleriesWithItems[] = [
                'gallery' => $gallery,
                'items' => $items,
                'itemCount' => count($items),
            ];
        }

        view('admin/gallery/index', [
            'title' => 'Galerie - Admin Scanbox.ro',
            'galleries' => $galleriesWithItems,
        ]);
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

            $uploadPath = $imageHandler->upload($file, 'gallery');
            if ($uploadPath !== null) {
                $galleryItemModel->create([
                    'gallery_id' => $galleryId,
                    'image_path' => $uploadPath,
                    'alt_text' => pathinfo($file['name'], PATHINFO_FILENAME),
                    'sort_order' => $galleryItemModel->getMaxSortOrder($galleryId) + 1,
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
     * Lista proiecte portofoliu in admin
     */
    public function portfolio(): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();

        $categoryFilter = $_GET['category'] ?? null;
        if ($categoryFilter) {
            $projects = $projectModel->getByCategoryId((int) $categoryFilter);
        } else {
            $projects = $projectModel->getAll();
        }

        $categories = $categoryModel->getAll();

        view('admin/portfolio/index', [
            'title' => 'Portofoliu - Admin Scanbox.ro',
            'projects' => $projects,
            'categories' => $categories,
            'currentCategory' => $categoryFilter,
        ]);
    }

    /**
     * Proiect nou in portofoliu (GET/POST)
     */
    public function portfolioNew(): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => $this->generateSlug($_POST['title'] ?? ''),
                'description' => $_POST['description'] ?? '',
                'short_description' => trim($_POST['short_description'] ?? ''),
                'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'client_name' => trim($_POST['client_name'] ?? ''),
                'project_date' => !empty($_POST['project_date']) ? $_POST['project_date'] : null,
                'project_url' => trim($_POST['project_url'] ?? ''),
                'video_url' => trim($_POST['video_url'] ?? ''),
                'latitude' => !empty($_POST['latitude']) ? (float) $_POST['latitude'] : null,
                'longitude' => !empty($_POST['longitude']) ? (float) $_POST['longitude'] : null,
                'type' => $_POST['type'] ?? 'standard',
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ];

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                header('Location: /admin/portfolio/new');
                exit;
            }

            // Upload thumbnail
            if (!empty($_FILES['thumbnail']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail'], 'portfolio');
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            $projectId = $projectModel->create($data);
            $this->logActivity('portfolio_create', "Proiect creat: {$data['title']} (ID: {$projectId})");

            $_SESSION['flash_success'] = 'Proiectul a fost creat cu succes.';
            header('Location: /admin/portfolio');
            exit;
        }

        $categories = $categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/portfolio/form', [
            'title' => 'Proiect Nou - Admin Scanbox.ro',
            'project' => null,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => '/admin/portfolio/new',
        ]);
    }

    /**
     * Editare proiect portofoliu (GET/POST)
     */
    public function portfolioEdit(int $id): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();

        $project = $projectModel->getById($id);
        if ($project === null) {
            $_SESSION['flash_error'] = 'Proiectul nu a fost găsit.';
            header('Location: /admin/portfolio');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => !empty($_POST['slug']) ? $this->generateSlug($_POST['slug']) : $this->generateSlug($_POST['title'] ?? ''),
                'description' => $_POST['description'] ?? '',
                'short_description' => trim($_POST['short_description'] ?? ''),
                'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'client_name' => trim($_POST['client_name'] ?? ''),
                'project_date' => !empty($_POST['project_date']) ? $_POST['project_date'] : null,
                'project_url' => trim($_POST['project_url'] ?? ''),
                'video_url' => trim($_POST['video_url'] ?? ''),
                'latitude' => !empty($_POST['latitude']) ? (float) $_POST['latitude'] : null,
                'longitude' => !empty($_POST['longitude']) ? (float) $_POST['longitude'] : null,
                'type' => $_POST['type'] ?? $project['type'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ];

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul este obligatoriu.';
                header("Location: /admin/portfolio/edit/{$id}");
                exit;
            }

            // Upload thumbnail daca exista fisier nou
            if (!empty($_FILES['thumbnail']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail'], 'portfolio');
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            $projectModel->update($id, $data);
            $this->logActivity('portfolio_update', "Proiect actualizat: {$data['title']} (ID: {$id})");

            $_SESSION['flash_success'] = 'Proiectul a fost actualizat cu succes.';
            header('Location: /admin/portfolio');
            exit;
        }

        $categories = $categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/portfolio/form', [
            'title' => 'Editare Proiect - Admin Scanbox.ro',
            'project' => $project,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => "/admin/portfolio/edit/{$id}",
        ]);
    }

    /**
     * Stergere proiect portofoliu (POST)
     */
    public function portfolioDelete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/portfolio');
            exit;
        }

        $this->validateCsrf();

        $projectModel = new Project();
        $project = $projectModel->getById($id);

        if ($project !== null) {
            $projectModel->delete($id);
            $this->logActivity('portfolio_delete', "Proiect șters: {$project['title']} (ID: {$id})");
            $_SESSION['flash_success'] = 'Proiectul a fost șters.';
        } else {
            $_SESSION['flash_error'] = 'Proiectul nu a fost găsit.';
        }

        header('Location: /admin/portfolio');
        exit;
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
                        if ($uploadResult !== null) {
                            $data['avatar'] = $uploadResult;
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
                        if ($uploadResult !== null) {
                            $data['avatar'] = $uploadResult;
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

        view('admin/testimonials/index', [
            'title' => 'Testimoniale - Admin Scanbox.ro',
            'testimonials' => $testimonials,
            'csrfToken' => $this->generateCsrf(),
        ]);
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
                        if ($uploadResult !== null) {
                            $data['logo_path'] = $uploadResult;
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
                        if ($uploadResult !== null) {
                            $data['logo_path'] = $uploadResult;
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

        view('admin/clients/index', [
            'title' => 'Clienți - Admin Scanbox.ro',
            'clients' => $clients,
            'csrfToken' => $this->generateCsrf(),
        ]);
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

        view('admin/messages/index', [
            'title' => 'Mesaje - Admin Scanbox.ro',
            'messages' => $messages,
            'currentStatus' => $status,
        ]);
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
        ]);
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
        ]);
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

        view('admin/pricing/index', [
            'title' => 'Prețuri - Admin Scanbox.ro',
            'packages' => $packages,
            'services' => $services,
            'csrfToken' => $this->generateCsrf(),
        ]);
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
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin/dashboard'));
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
                'user_id' => $_SESSION['user_id'],
                'action' => $action,
                'description' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Eroare logare activitate: ' . $e->getMessage());
        }
    }
}
