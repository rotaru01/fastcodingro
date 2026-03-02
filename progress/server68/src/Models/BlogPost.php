<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class BlogPost
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";

        $params = [];
        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $params[] = $offset;
            }
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function getPublished(?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT * FROM blog_posts WHERE status = 'published' AND published_at <= NOW() ORDER BY published_at DESC";

        $params = [];
        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $params[] = $offset;
            }
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT bp.*, bc.name as category_name, bc.slug as category_slug
             FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             WHERE bp.slug = ?",
            [$slug]
        );
    }

    public function getByStatus(string $status, ?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT * FROM blog_posts WHERE status = ? ORDER BY created_at DESC";
        $params = [$status];

        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $params[] = $offset;
            }
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM blog_posts WHERE id = ?",
            [$id]
        );
    }

    public function getByCategory(int $categoryId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM blog_posts WHERE category_id = ? AND status = 'published' ORDER BY published_at DESC",
            [$categoryId]
        );
    }

    public function getRecent(int $limit = 5): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM blog_posts WHERE status = 'published' AND published_at <= NOW() ORDER BY published_at DESC LIMIT ?",
            [$limit]
        );
    }

    public function search(string $query): array
    {
        $searchTerm = '%' . $query . '%';

        return $this->db->fetchAll(
            "SELECT * FROM blog_posts
             WHERE status = 'published'
               AND published_at <= NOW()
               AND (title LIKE ? OR excerpt LIKE ? OR content LIKE ? OR tags LIKE ?)
             ORDER BY published_at DESC",
            [$searchTerm, $searchTerm, $searchTerm, $searchTerm]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if (isset($data['status']) && $data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        return $this->db->insert('blog_posts', $data);
    }

    public function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('blog_posts', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('blog_posts', 'id = ?', [$id]);
    }

    public function publish(int $id): int
    {
        return $this->db->update(
            'blog_posts',
            [
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            'id = ?',
            [$id]
        );
    }

    public function countPublished(): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as total FROM blog_posts WHERE status = 'published' AND published_at <= NOW()"
        );

        return (int) ($result['total'] ?? 0);
    }

    public function countAll(): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as total FROM blog_posts"
        );

        return (int) ($result['total'] ?? 0);
    }
}
