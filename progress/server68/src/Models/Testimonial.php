<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Testimonial
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM testimonials ORDER BY sort_order ASC, id DESC"
        );
    }

    public function getActive(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC, id DESC"
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM testimonials WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('testimonials', $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->db->update('testimonials', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('testimonials', 'id = ?', [$id]);
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sortOrder => $id) {
            $this->db->update(
                'testimonials',
                ['sort_order' => $sortOrder + 1],
                'id = ?',
                [(int) $id]
            );
        }
    }

    public function toggleActive(int $id): int
    {
        $item = $this->getById($id);
        if ($item === null) {
            return 0;
        }

        $newStatus = $item['is_active'] ? 0 : 1;

        return $this->db->update(
            'testimonials',
            ['is_active' => $newStatus],
            'id = ?',
            [$id]
        );
    }
}
