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
            'title' => 'Scanbox.ro - Servicii Profesionale de Scanare 3D și Fotografie',
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
        $service = $this->serviceModel->getBySlug($slug);

        if ($service === null) {
            http_response_code(404);
            view('pages/404', [
                'title' => 'Pagina nu a fost gasită - Scanbox.ro',
            ]);
            return;
        }

        $gallery = $this->galleryModel->getByServiceId((int) $service['id']);
        $galleryItems = [];
        if ($gallery !== null) {
            $galleryItems = $this->galleryItemModel->getByGalleryId((int) $gallery['id']);
        }

        $pricing = $this->pricingModel->getByServiceId((int) $service['id']);
        $settings = $this->settingModel->getAll();

        view('pages/services/show', [
            'title' => htmlspecialchars($service['title']) . ' - Scanbox.ro',
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
        $galleries = $this->galleryModel->getByType('sport');
        $galleryData = [];

        foreach ($galleries as $gallery) {
            $items = $this->galleryItemModel->getByGalleryId((int) $gallery['id']);
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
        $categories = (new Category())->getAll();
        $projects = $this->projectModel->getActive();

        $mapData = [];
        foreach ($projects as $project) {
            if (!empty($project['latitude']) && !empty($project['longitude'])) {
                $mapData[] = [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'lat' => (float) $project['latitude'],
                    'lng' => (float) $project['longitude'],
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
        $projects = $this->projectModel->getByType('reels');
        $settings = $this->settingModel->getAll();

        view('pages/portofoliu-reels', [
            'title' => 'Portofoliu Reels - Scanbox.ro',
            'projects' => $projects,
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
            'title' => 'Despre Noi - Scanbox.ro',
            'settings' => $settings,
            'testimonials' => $testimonials,
            'clientLogos' => $clientLogos,
        ]);
    }
}
