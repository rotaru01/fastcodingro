<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Gallery
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM galleries ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getByPage(string $page): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM galleries WHERE page = ? AND is_active = 1 ORDER BY sort_order ASC",
            [$page]
        );
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM galleries WHERE slug = ?",
            [$slug]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM galleries WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('galleries', $data);
    }

    public function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('galleries', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('galleries', 'id = ?', [$id]);
    }
}
