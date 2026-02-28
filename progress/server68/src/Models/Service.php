<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Service
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM services ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getActive(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM services WHERE slug = ?",
            [$slug]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM services WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('services', $data);
    }

    public function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('services', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('services', 'id = ?', [$id]);
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sortOrder => $id) {
            $this->db->update(
                'services',
                ['sort_order' => $sortOrder + 1, 'updated_at' => date('Y-m-d H:i:s')],
                'id = ?',
                [(int) $id]
            );
        }
    }
}
