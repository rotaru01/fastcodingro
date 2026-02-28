<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class PricingPackage
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM pricing_packages ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getByService(string $servicePage): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM pricing_packages WHERE service_page = ? ORDER BY sort_order ASC, id ASC",
            [$servicePage]
        );
    }

    public function getActive(?string $servicePage = null): array
    {
        if ($servicePage !== null) {
            return $this->db->fetchAll(
                "SELECT * FROM pricing_packages WHERE is_active = 1 AND service_page = ? ORDER BY sort_order ASC, id ASC",
                [$servicePage]
            );
        }

        return $this->db->fetchAll(
            "SELECT * FROM pricing_packages WHERE is_active = 1 ORDER BY sort_order ASC, id ASC"
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM pricing_packages WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('pricing_packages', $data);
    }

    public function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('pricing_packages', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('pricing_packages', 'id = ?', [$id]);
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sortOrder => $id) {
            $this->db->update(
                'pricing_packages',
                ['sort_order' => $sortOrder + 1, 'updated_at' => date('Y-m-d H:i:s')],
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
            'pricing_packages',
            ['is_active' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')],
            'id = ?',
            [$id]
        );
    }

    public function toggleFeatured(int $id): int
    {
        $item = $this->getById($id);
        if ($item === null) {
            return 0;
        }

        $newStatus = $item['is_featured'] ? 0 : 1;

        return $this->db->update(
            'pricing_packages',
            ['is_featured' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')],
            'id = ?',
            [$id]
        );
    }
}
