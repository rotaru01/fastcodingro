<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Project
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_projects ORDER BY sort_order ASC, id DESC"
        );
    }

    public function getActive(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_projects WHERE is_active = 1 ORDER BY sort_order ASC, id DESC"
        );
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM portfolio_projects WHERE slug = ?",
            [$slug]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM portfolio_projects WHERE id = ?",
            [$id]
        );
    }

    public function getByCategory(int $categoryId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_projects WHERE category_id = ? AND is_active = 1 ORDER BY sort_order ASC, id DESC",
            [$categoryId]
        );
    }

    public function getFeatured(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_projects WHERE is_featured = 1 AND is_active = 1 ORDER BY sort_order ASC, id DESC"
        );
    }

    public function getForMap(?int $category = null): array
    {
        if ($category !== null) {
            return $this->db->fetchAll(
                "SELECT id, slug, title, latitude, longitude, thumbnail, city, address, matterport_url, category_id
                 FROM portfolio_projects
                 WHERE is_active = 1 AND latitude IS NOT NULL AND longitude IS NOT NULL AND category_id = ?
                 ORDER BY sort_order ASC",
                [$category]
            );
        }

        return $this->db->fetchAll(
            "SELECT id, slug, title, latitude, longitude, thumbnail, city, address, matterport_url, category_id
             FROM portfolio_projects
             WHERE is_active = 1 AND latitude IS NOT NULL AND longitude IS NOT NULL
             ORDER BY sort_order ASC"
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('portfolio_projects', $data);
    }

    public function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('portfolio_projects', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('portfolio_projects', 'id = ?', [$id]);
    }

    public function incrementViews(int $id): int
    {
        $this->db->query(
            "UPDATE portfolio_projects SET views_count = views_count + 1 WHERE id = ?",
            [$id]
        );

        $result = $this->db->fetch(
            "SELECT views_count FROM portfolio_projects WHERE id = ?",
            [$id]
        );

        return $result ? (int) $result['views_count'] : 0;
    }
}
