<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Models\Service;
use Scanbox\Models\Project;
use Scanbox\Models\Testimonial;
use Scanbox\Models\ClientLogo;
use Scanbox\Models\BlogPost;
use Scanbox\Models\Setting;
use Scanbox\Models\PricingPackage;
use Scanbox\Models\Gallery;
use Scanbox\Models\GalleryItem;
use Scanbox\Models\Category;

class PageController
{
    private Service $serviceModel;
    private Project $projectModel;
    private Testimonial $testimonialModel;
    private ClientLogo $clientLogoModel;
    private BlogPost $blogPostModel;
    private Setting $settingModel;
    private PricingPackage $pricingModel;
    private Gallery $galleryModel;
    private GalleryItem $galleryItemModel;

    public function __construct()
    {
        $this->serviceModel = new Service();
        $this->projectModel = new Project();
        $this->testimonialModel = new Testimonial();
        $this->clientLogoModel = new ClientLogo();
        $this->blogPostModel = new BlogPost();
        $this->settingModel = new Setting();
        $this->pricingModel = new PricingPackage();
        $this->galleryModel = new Gallery();
        $this->galleryItemModel = new GalleryItem();
    }

    /**
     * Pagina principala - homepage
     */
    public function home(): void
    {
        $services = $this->serviceModel->getActive();
        $featuredProjects = $this->projectModel->getFeatured();
        $testimonials = $this->testimonialModel->getActive();
        $clientLogos = $this->clientLogoModel->getActive();
        $recentPosts = $this->blogPostModel->getRecent(3);
        $settings = $this->settingModel->getAll();

        view('pages/home', [
            'title' => 'Scanbox.ro — Tur Virtual 3D Matterport, Fotografie, Video Drone, Randare 3D',
            'metaDescription' => 'Scanbox.ro — Reseller Oficial Matterport România. Tururi virtuale 3D, fotografie profesională, videografie drone 4K, randare 3D și social media pentru afaceri.',
            'services' => $services,
            'featuredProjects' => $featuredProjects,
            'testimonials' => $testimonials,
            'clientLogos' => $clientLogos,
            'recentPosts' => $recentPosts,
            'settings' => $settings,
        ]);
    }

    /**
     * Pagina serviciu individual
     */
    public function servicii(string $slug): void
    {
        if (!in_array($slug, VALID_SERVICE_SLUGS, true)) {
            http_response_code(404);
            view('pages/404', ['title' => 'Pagina nu a fost gasită - Scanbox.ro']);
            return;
        }

        $service = $this->serviceModel->getBySlug($slug);
        $settings = $this->settingModel->getAll();

        // Static views exist for each service - work even without DB data
        if ($service === null) {
            $service = ['slug' => $slug, 'title' => ucfirst(str_replace('-', ' ', $slug))];
        }

        // Incarca galeria asociata serviciului (pe baza slug-ului ca page)
        $galleryItems = [];
        $gallery = null;
        $galleries = $this->galleryModel->getByPage($slug);
        if (!empty($galleries)) {
            $gallery = $galleries[0];
            $galleryItems = $this->galleryItemModel->getByGallery((int) $gallery['id']);
        }

        $pricing = $this->pricingModel->getByService($slug);

        view('pages/services/show', [
            'title' => htmlspecialchars($service['title'] ?? $slug) . ' - Scanbox.ro',
            'service' => $service,
            'gallery' => $gallery,
            'galleryItems' => $galleryItems,
            'pricing' => $pricing,
            'settings' => $settings,
        ]);
    }

    /**
     * Pagina sport content
     */
    public function sportContent(): void
    {
        $galleries = $this->galleryModel->getByPage('sport');
        $galleryData = [];

        foreach ($galleries as $gallery) {
            $items = $this->galleryItemModel->getByGallery((int) $gallery['id']);
            $galleryData[] = [
                'gallery' => $gallery,
                'items' => $items,
            ];
        }

        $settings = $this->settingModel->getAll();

        view('pages/sport-content', [
            'title' => 'Sport Content - Scanbox.ro',
            'galleries' => $galleryData,
            'settings' => $settings,
        ]);
    }

    /**
     * Pagina portofoliu
     */
    public function portofoliu(): void
    {
        $db = \Scanbox\Core\Database::getInstance();
        $categories = $db->fetchAll("SELECT * FROM portfolio_categories WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
        $projects = $db->fetchAll(
            "SELECT p.*, c.name_ro as category_name, c.slug as category_slug
             FROM portfolio_projects p
             LEFT JOIN portfolio_categories c ON p.category_id = c.id
             WHERE p.is_active = 1
             ORDER BY p.sort_order ASC, p.id DESC"
        );

        $mapData = [];
        foreach ($projects as $project) {
            if (!empty($project['lat']) && !empty($project['lng'])) {
                $mapData[] = [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'lat' => (float) $project['lat'],
                    'lng' => (float) $project['lng'],
                    'thumbnail' => $project['thumbnail'] ?? '',
                    'slug' => $project['slug'] ?? '',
                ];
            }
        }

        $settings = $this->settingModel->getAll();

        view('pages/portofoliu', [
            'title' => 'Portofoliu - Scanbox.ro',
            'categories' => $categories,
            'projects' => $projects,
            'mapData' => json_encode($mapData, JSON_UNESCAPED_UNICODE),
            'settings' => $settings,
        ]);
    }

    /**
     * Pagina portofoliu reels
     */
    public function portofoliuReels(): void
    {
        $settings = $this->settingModel->getAll();

        // Luam galeria "portofoliu-reels" si elementele ei din DB
        $reelsItems = [];
        $gallery = $this->galleryModel->getBySlug('portofoliu-reels');
        if ($gallery) {
            $reelsItems = $this->galleryItemModel->getByGallery((int) $gallery['id']);
        }

        view('pages/portofoliu-reels', [
            'title' => 'Portofoliu Reels - Scanbox.ro',
            'reelsItems' => $reelsItems,
            'settings' => $settings,
        ]);
    }

    /**
     * Pagina contact
     */
    public function contact(): void
    {
        $settings = $this->settingModel->getAll();

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('pages/contact', [
            'title' => 'Contact - Scanbox.ro',
            'settings' => $settings,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Pagina despre noi
     */
    public function despreNoi(): void
    {
        $settings = $this->settingModel->getAll();
        $testimonials = $this->testimonialModel->getActive();
        $clientLogos = $this->clientLogoModel->getActive();

        view('pages/despre-noi', [
            'title' => 'Despre Noi — Scanbox.ro | Reseller Oficial Matterport România',
            'metaDescription' => 'Echipa Scanbox.ro — Reseller Oficial Matterport pentru România și Republica Moldova. Peste 5 ani experiență în tururi virtuale 3D, fotografie și videografie profesională.',
            'settings' => $settings,
            'testimonials' => $testimonials,
            'clientLogos' => $clientLogos,
        ]);
    }

    /**
     * Pagini legale (GDPR, Cookies)
     */
    public function legal(string $slug): void
    {
        $validSlugs = ['prelucrarea-datelor', 'politica-cookies'];
        if (!in_array($slug, $validSlugs, true)) {
            http_response_code(404);
            view('pages/404');
            return;
        }

        view('pages/legal/' . $slug);
    }
}
