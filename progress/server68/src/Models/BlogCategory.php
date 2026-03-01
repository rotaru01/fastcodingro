<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class BlogCategory
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM blog_categories ORDER BY name ASC"
        );
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM blog_categories WHERE slug = ?",
            [$slug]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM blog_categories WHERE id = ?",
            [$id]
        );
    }
}
