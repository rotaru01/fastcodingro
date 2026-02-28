<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Message
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(?string $status = null, ?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT * FROM messages";
        $params = [];

        if ($status !== null) {
            $sql .= " WHERE status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";

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
            "SELECT * FROM messages WHERE id = ?",
            [$id]
        );
    }

    public function getUnread(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM messages WHERE status = 'new' ORDER BY created_at DESC"
        );
    }

    public function getRecent(int $limit = 5): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM messages ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }

    public function create(array $data): int
    {
        $data['status'] = $data['status'] ?? 'new';
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('messages', $data);
    }

    public function markAsRead(int $id): int
    {
        return $this->db->update(
            'messages',
            [
                'status' => 'read',
                'read_at' => date('Y-m-d H:i:s'),
            ],
            'id = ?',
            [$id]
        );
    }

    public function markAsReplied(int $id): int
    {
        return $this->db->update(
            'messages',
            [
                'status' => 'replied',
                'replied_at' => date('Y-m-d H:i:s'),
            ],
            'id = ?',
            [$id]
        );
    }

    public function archive(int $id): int
    {
        return $this->db->update(
            'messages',
            ['status' => 'archived'],
            'id = ?',
            [$id]
        );
    }

    public function delete(int $id): int
    {
        return $this->db->delete('messages', 'id = ?', [$id]);
    }

    public function countUnread(): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as total FROM messages WHERE status = 'new'"
        );

        return (int) ($result['total'] ?? 0);
    }

    public function countAll(): int
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as total FROM messages"
        );

        return (int) ($result['total'] ?? 0);
    }
}
