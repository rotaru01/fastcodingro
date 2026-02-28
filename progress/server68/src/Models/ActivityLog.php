<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class ActivityLog
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function log(
        int $adminId,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?string $details = null
    ): int {
        $data = [
            'admin_id' => $adminId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        return $this->db->insert('activity_log', $data);
    }

    public function getRecent(int $limit = 20): array
    {
        return $this->db->fetchAll(
            "SELECT al.*, a.username, a.name as admin_name
             FROM activity_log al
             LEFT JOIN admins a ON al.admin_id = a.id
             ORDER BY al.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getByAdmin(int $adminId, int $limit = 50): array
    {
        return $this->db->fetchAll(
            "SELECT al.*, a.username, a.name as admin_name
             FROM activity_log al
             LEFT JOIN admins a ON al.admin_id = a.id
             WHERE al.admin_id = ?
             ORDER BY al.created_at DESC
             LIMIT ?",
            [$adminId, $limit]
        );
    }

    public function getAll(int $limit = 100, int $offset = 0): array
    {
        return $this->db->fetchAll(
            "SELECT al.*, a.username, a.name as admin_name
             FROM activity_log al
             LEFT JOIN admins a ON al.admin_id = a.id
             ORDER BY al.created_at DESC
             LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }

    public function cleanup(int $daysOld = 90): int
    {
        return $this->db->delete(
            'activity_log',
            'created_at < DATE_SUB(NOW(), INTERVAL ? DAY)',
            [$daysOld]
        );
    }
}
