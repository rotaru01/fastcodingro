<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Admin
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByUsername(string $username): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM admins WHERE username = ?",
            [$username]
        );
    }

    public function getByEmail(string $email): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM admins WHERE email = ?",
            [$email]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM admins WHERE id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        if (isset($data['password'])) {
            $data['password_hash'] = $this->hashPassword($data['password']);
            unset($data['password']);
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['is_active'] = $data['is_active'] ?? 1;

        return $this->db->insert('admins', $data);
    }

    public function update(int $id, array $data): int
    {
        if (isset($data['password'])) {
            $data['password_hash'] = $this->hashPassword($data['password']);
            unset($data['password']);
        }

        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->update('admins', $data, 'id = ?', [$id]);
    }

    public function updateLastLogin(int $id): int
    {
        return $this->db->update(
            'admins',
            ['last_login' => date('Y-m-d H:i:s')],
            'id = ?',
            [$id]
        );
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3,
        ]);
    }

    public function getAll(): array
    {
        return $this->db->fetchAll(
            "SELECT id, username, email, name, role, last_login, created_at, updated_at, is_active
             FROM admins
             ORDER BY id ASC"
        );
    }

    public function delete(int $id): int
    {
        return $this->db->delete('admins', 'id = ?', [$id]);
    }
}
