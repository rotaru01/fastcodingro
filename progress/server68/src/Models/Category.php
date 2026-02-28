<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Category
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_categories ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getActive(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM portfolio_categories WHERE is_active = 1 ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM portfolio_categories WHERE slug = ?",
            [$slug]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM portfolio_categories WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('portfolio_categories', $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->db->update('portfolio_categories', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('portfolio_categories', 'id = ?', [$id]);
    }
}
