<?php
declare(strict_types=1);

namespace Scanbox\Core;

/**
 * Generator de Schema.org JSON-LD markup pentru GEO (Generative Engine Optimization)
 * Genereaza date structurate pentru AI search engines: Google AI Overviews, ChatGPT, Perplexity, Claude
 */
class SchemaMarkup
{
    private const SITE_NAME = 'Scanbox.ro';
    private const LEGAL_NAME = 'TRIVIT SERVICES S.R.L.';
    private const SITE_URL = 'https://scanbox.ro';
    private const PHONE = '+40740233353';
    private const EMAIL = 'office@scanbox.ro';
    private const ADDRESS_STREET = 'Str. Moroeni 60D';
    private const ADDRESS_CITY = 'București';
    private const ADDRESS_REGION = 'Sector 2';
    private const ADDRESS_COUNTRY = 'RO';
    private const LOGO_URL = 'https://scanbox.ro/assets/images/logo.png';
    private const FOUNDED = '2018';

    private const SOCIAL_PROFILES = [
        'https://www.instagram.com/scanbox.ro/',
        'https://www.facebook.com/scanbox.ro',
        'https://www.tiktok.com/@scanbox.ro',
        'https://www.youtube.com/@scanboxintegratedvisualsol9014',
        'https://www.linkedin.com/company/scanbox-visual-solutions/',
    ];

    /**
     * Schema Organization — entitatea principala a brand-ului
     * Folosita pe toate paginile pentru identificare entitate
     */
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => self::SITE_URL . '/#organization',
            'name' => self::SITE_NAME,
            'legalName' => self::LEGAL_NAME,
            'url' => self::SITE_URL,
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => self::SITE_URL . '/#logo',
                'url' => self::LOGO_URL,
                'width' => 512,
                'height' => 512,
            ],
            'image' => self::LOGO_URL,
            'telephone' => self::PHONE,
            'email' => self::EMAIL,
            'foundingDate' => self::FOUNDED,
            'numberOfEmployees' => [
                '@type' => 'QuantitativeValue',
                'minValue' => 5,
                'maxValue' => 15,
            ],
            'address' => self::postalAddress(),
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 44.4268,
                'longitude' => 26.1025,
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'România'],
                ['@type' => 'Country', 'name' => 'Republica Moldova'],
            ],
            'sameAs' => self::SOCIAL_PROFILES,
            'knowsAbout' => [
                'Tur Virtual 3D Matterport',
                'Scanare 3D',
                'Fotografie Profesională',
                'Videografie Drone 4K',
                'Randare 3D Fotorealistă',
                'Social Media Management',
                'Content Creation',
                'Sport Photography',
                'Digital Twin',
                'Matterport Pro 2',
                'Matterport Pro 3',
            ],
            'hasCredential' => [
                '@type' => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Reseller Oficial',
                'name' => 'Reseller Oficial Matterport — România și Republica Moldova',
            ],
        ];
    }

    /**
     * Schema LocalBusiness — pentru Google Maps si AI local search
     */
    public static function localBusiness(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => self::SITE_URL . '/#localbusiness',
            'name' => self::SITE_NAME,
            'legalName' => self::LEGAL_NAME,
            'url' => self::SITE_URL,
            'logo' => self::LOGO_URL,
            'image' => self::LOGO_URL,
            'telephone' => self::PHONE,
            'email' => self::EMAIL,
            'priceRange' => '€€',
            'currenciesAccepted' => 'EUR, RON',
            'paymentAccepted' => 'Transfer bancar, Card',
            'address' => self::postalAddress(),
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 44.4268,
                'longitude' => 26.1025,
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '09:00',
                'closes' => '18:00',
            ],
            'sameAs' => self::SOCIAL_PROFILES,
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '47',
                'bestRating' => '5',
            ],
        ];
    }

    /**
     * Schema WebSite — cu SearchAction pentru sitelinks search box
     */
    public static function webSite(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => self::SITE_URL . '/#website',
            'name' => self::SITE_NAME,
            'url' => self::SITE_URL,
            'publisher' => ['@id' => self::SITE_URL . '/#organization'],
            'inLanguage' => 'ro-RO',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => self::SITE_URL . '/blog?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Schema WebPage — per pagina
     */
    public static function webPage(string $url, string $name, string $description, ?string $dateModified = null): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'name' => $name,
            'description' => $description,
            'isPartOf' => ['@id' => self::SITE_URL . '/#website'],
            'about' => ['@id' => self::SITE_URL . '/#organization'],
            'inLanguage' => 'ro-RO',
            'dateModified' => $dateModified ?? date('Y-m-d'),
        ];
    }

    /**
     * Schema Service — per serviciu oferit
     */
    public static function service(
        string $name,
        string $description,
        string $url,
        ?string $image = null,
        ?string $priceFrom = null,
        ?string $currency = 'EUR'
    ): array {
        $service = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $name,
            'description' => $description,
            'url' => $url,
            'provider' => ['@id' => self::SITE_URL . '/#organization'],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'România'],
                ['@type' => 'Country', 'name' => 'Republica Moldova'],
            ],
            'serviceType' => $name,
            'availableChannel' => [
                '@type' => 'ServiceChannel',
                'serviceUrl' => self::SITE_URL . '/contact',
                'servicePhone' => self::PHONE,
            ],
        ];

        if ($image) {
            $service['image'] = $image;
        }

        if ($priceFrom) {
            $service['offers'] = [
                '@type' => 'Offer',
                'priceSpecification' => [
                    '@type' => 'UnitPriceSpecification',
                    'price' => $priceFrom,
                    'priceCurrency' => $currency,
                    'unitText' => 'proiect',
                ],
                'availability' => 'https://schema.org/InStock',
            ];
        }

        return $service;
    }

    /**
     * Schema FAQPage — pentru sectiunile FAQ (critice pentru GEO)
     * AI engines folosesc FAQ schema cu rata de citare de 67%
     */
    public static function faqPage(array $questionsAnswers): array
    {
        $mainEntity = [];
        foreach ($questionsAnswers as $qa) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $qa['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $qa['answer'],
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity,
        ];
    }

    /**
     * Schema HowTo — pentru procesele pas cu pas
     */
    public static function howTo(string $name, string $description, array $steps, ?string $totalTime = null): array
    {
        $howToSteps = [];
        foreach ($steps as $i => $step) {
            $howToSteps[] = [
                '@type' => 'HowToStep',
                'position' => $i + 1,
                'name' => $step['name'],
                'text' => $step['text'],
            ];
        }

        $howTo = [
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => $name,
            'description' => $description,
            'step' => $howToSteps,
        ];

        if ($totalTime) {
            $howTo['totalTime'] = $totalTime;
        }

        return $howTo;
    }

    /**
     * Schema BreadcrumbList — navigare contextuala
     */
    public static function breadcrumbList(array $items): array
    {
        $listItems = [];
        foreach ($items as $i => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /**
     * Schema BlogPosting — pentru articole blog
     */
    public static function blogPosting(
        string $title,
        string $description,
        string $url,
        string $datePublished,
        ?string $dateModified = null,
        ?string $image = null,
        ?string $authorName = null
    ): array {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $title,
            'description' => $description,
            'url' => $url,
            'datePublished' => $datePublished,
            'dateModified' => $dateModified ?? $datePublished,
            'image' => $image,
            'author' => [
                '@type' => 'Organization',
                'name' => self::SITE_NAME,
                '@id' => self::SITE_URL . '/#organization',
            ],
            'publisher' => ['@id' => self::SITE_URL . '/#organization'],
            'inLanguage' => 'ro-RO',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
        ];
    }

    /**
     * Schema Offer — pentru pachete de pret
     */
    public static function offerCatalog(string $serviceName, array $packages): array
    {
        $offers = [];
        foreach ($packages as $pkg) {
            $offer = [
                '@type' => 'Offer',
                'name' => $pkg['name'],
                'price' => $pkg['price'],
                'priceCurrency' => $pkg['currency'] ?? 'EUR',
                'availability' => 'https://schema.org/InStock',
            ];
            if (!empty($pkg['description'])) {
                $offer['description'] = $pkg['description'];
            }
            $offers[] = $offer;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'OfferCatalog',
            'name' => 'Pachete ' . $serviceName,
            'itemListElement' => $offers,
        ];
    }

    /**
     * Schema Review/AggregateRating — testimoniale
     */
    public static function aggregateRating(float $ratingValue, int $reviewCount): array
    {
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => number_format($ratingValue, 1),
            'reviewCount' => $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }

    /**
     * Genereaza markup JSON-LD complet pentru homepage
     */
    public static function homePage(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::removeContext(self::organization()),
                self::removeContext(self::localBusiness()),
                self::removeContext(self::webSite()),
                self::removeContext(self::webPage(
                    self::SITE_URL,
                    'Scanbox.ro — Soluții Vizuale Profesionale | Tur Virtual 3D, Fotografie, Video',
                    'Scanbox.ro oferă servicii profesionale de tur virtual 3D Matterport, fotografie, videografie drone, randare 3D și social media content. Reseller Oficial Matterport România. 150+ tururi virtuale, 500+ proiecte.'
                )),
                self::removeContext(self::breadcrumbList([
                    ['name' => 'Acasă', 'url' => self::SITE_URL],
                ])),
            ],
        ];
    }

    /**
     * Genereaza markup complet pentru o pagina de serviciu
     */
    public static function servicePage(
        string $slug,
        string $title,
        string $description,
        array $faq = [],
        ?string $priceFrom = null
    ): array {
        $url = self::SITE_URL . '/servicii/' . $slug;
        $graph = [
            self::removeContext(self::organization()),
            self::removeContext(self::webPage($url, $title, $description)),
            self::removeContext(self::service($title, $description, $url, null, $priceFrom)),
            self::removeContext(self::breadcrumbList([
                ['name' => 'Acasă', 'url' => self::SITE_URL],
                ['name' => 'Servicii', 'url' => self::SITE_URL . '/servicii'],
                ['name' => $title, 'url' => $url],
            ])),
        ];

        if (!empty($faq)) {
            $graph[] = self::removeContext(self::faqPage($faq));
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    /**
     * Genereaza markup complet pentru pagina de blog
     */
    public static function blogPage(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::removeContext(self::organization()),
                self::removeContext(self::webPage(
                    self::SITE_URL . '/blog',
                    'Blog — Scanbox.ro',
                    'Articole despre tururi virtuale 3D, fotografie profesională, videografie drone, randare 3D și social media. Sfaturi, ghiduri și noutăți.'
                )),
                self::removeContext(self::breadcrumbList([
                    ['name' => 'Acasă', 'url' => self::SITE_URL],
                    ['name' => 'Blog', 'url' => self::SITE_URL . '/blog'],
                ])),
            ],
        ];
    }

    /**
     * Genereaza markup complet pentru un articol blog
     */
    public static function blogPostPage(
        string $slug,
        string $title,
        string $description,
        string $datePublished,
        ?string $dateModified = null,
        ?string $image = null
    ): array {
        $url = self::SITE_URL . '/blog/' . $slug;
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::removeContext(self::organization()),
                self::removeContext(self::blogPosting($title, $description, $url, $datePublished, $dateModified, $image)),
                self::removeContext(self::breadcrumbList([
                    ['name' => 'Acasă', 'url' => self::SITE_URL],
                    ['name' => 'Blog', 'url' => self::SITE_URL . '/blog'],
                    ['name' => $title, 'url' => $url],
                ])),
            ],
        ];
    }

    /**
     * Genereaza markup complet pentru pagina Contact
     */
    public static function contactPage(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::removeContext(self::localBusiness()),
                self::removeContext(self::webPage(
                    self::SITE_URL . '/contact',
                    'Contact — Scanbox.ro',
                    'Contactează Scanbox.ro pentru servicii de tur virtual 3D, fotografie, videografie drone și social media. E-mail: office@scanbox.ro, Tel: 0740 233 353.'
                )),
                self::removeContext(self::breadcrumbList([
                    ['name' => 'Acasă', 'url' => self::SITE_URL],
                    ['name' => 'Contact', 'url' => self::SITE_URL . '/contact'],
                ])),
            ],
        ];
    }

    /**
     * Render JSON-LD script tag
     */
    public static function render(array $schema): string
    {
        return '<script type="application/ld+json">' . "\n"
            . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            . "\n</script>";
    }

    /**
     * Render multiple schema pe aceeasi pagina
     */
    public static function renderMultiple(array ...$schemas): string
    {
        $output = '';
        foreach ($schemas as $schema) {
            $output .= self::render($schema) . "\n";
        }
        return $output;
    }

    // -- Private helpers --

    private static function postalAddress(): array
    {
        return [
            '@type' => 'PostalAddress',
            'streetAddress' => self::ADDRESS_STREET,
            'addressLocality' => self::ADDRESS_CITY,
            'addressRegion' => self::ADDRESS_REGION,
            'addressCountry' => self::ADDRESS_COUNTRY,
        ];
    }

    private static function removeContext(array $schema): array
    {
        unset($schema['@context']);
        return $schema;
    }
}
