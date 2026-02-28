<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class GalleryItem
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByGallery(int $galleryId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM gallery_items WHERE gallery_id = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC",
            [$galleryId]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM gallery_items WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('gallery_items', $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->db->update('gallery_items', $data, 'id = ?', [$id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete('gallery_items', 'id = ?', [$id]);
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sortOrder => $id) {
            $this->db->update(
                'gallery_items',
                ['sort_order' => $sortOrder + 1],
                'id = ?',
                [(int) $id]
            );
        }
    }

    public function countByGallery(int $galleryId): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as total FROM gallery_items WHERE gallery_id = ? AND is_active = 1",
            [$galleryId]
        );

        return (int) ($result['total'] ?? 0);
    }
}
