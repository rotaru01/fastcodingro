<?php

declare(strict_types=1);

namespace Scanbox\Models;

use Scanbox\Core\Database;

class Setting
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $row = $this->db->fetch(
            "SELECT setting_value, setting_type FROM settings WHERE setting_key = ?",
            [$key]
        );

        if ($row === null) {
            return $default;
        }

        return $this->castValue($row['setting_value'], $row['setting_type']);
    }

    public function set(string $key, mixed $value): void
    {
        $existing = $this->db->fetch(
            "SELECT id FROM settings WHERE setting_key = ?",
            [$key]
        );

        $stringValue = is_array($value) || is_object($value)
            ? json_encode($value, JSON_UNESCAPED_UNICODE)
            : (string) $value;

        if ($existing !== null) {
            $this->db->update(
                'settings',
                [
                    'setting_value' => $stringValue,
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                'id = ?',
                [$existing['id']]
            );
        } else {
            $type = match (true) {
                is_bool($value) => 'boolean',
                is_int($value) || is_float($value) => 'number',
                is_array($value) || is_object($value) => 'json',
                default => 'text',
            };

            $this->db->insert('settings', [
                'setting_key' => $key,
                'setting_value' => $stringValue,
                'setting_type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function getByGroup(string $group): array
    {
        $rows = $this->db->fetchAll(
            "SELECT * FROM settings WHERE setting_group = ? ORDER BY setting_key ASC",
            [$group]
        );

        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $this->castValue($row['setting_value'], $row['setting_type']);
        }

        return $settings;
    }

    public function getAll(): array
    {
        $rows = $this->db->fetchAll(
            "SELECT * FROM settings ORDER BY setting_group ASC, setting_key ASC"
        );

        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = [
                'value' => $this->castValue($row['setting_value'], $row['setting_type']),
                'type' => $row['setting_type'],
                'group' => $row['setting_group'],
                'description' => $row['description'],
            ];
        }

        return $settings;
    }

    public function delete(string $key): int
    {
        return $this->db->delete('settings', 'setting_key = ?', [$key]);
    }

    private function castValue(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'number' => str_contains($value, '.') ? (float) $value : (int) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
}
