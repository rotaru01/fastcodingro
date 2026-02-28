<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class ClientLogo
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(?string $type = null): array
    {
        if ($type !== null) {
            return $this->db->fetchAll(
                "SELECT * FROM client_logos WHERE type = ? ORDER BY sort_order ASC, id ASC",
                [$type]
            );
        }

        return $this->db->fetchAll(
            "SELECT * FROM client_logos ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getActive(?string $type = null): array
    {
        if ($type !== null) {
            return $this->db->fetchAll(
                "SELECT * FROM client_logos WHERE is_active = 1 AND type = ? ORDER BY sort_order ASC, id ASC",
                [$type]
            );
        }

        return $this->db->fetchAll(
            "SELECT * FROM client_logos WHERE is_active = 1 ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM client_logos WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('client_logos', $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->db->update('client_logos', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('client_logos', 'id = ?', [$id]);
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sortOrder => $id) {
            $this->db->update(
                'client_logos',
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
            'client_logos',
            ['is_active' => $newStatus],
            'id = ?',
            [$id]
        );
    }
}
