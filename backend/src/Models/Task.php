<?php

namespace Jusa\Backend\Models;

use Jusa\Backend\Config\Database;
use PDO;

class Task
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM tasks ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title): array
    {
        $stmt = $this->db->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
        return ['id' => $this->db->lastInsertId(), 'title' => $title, 'completed' => false];
    }

    public function update(int $id, bool $completed): bool
    {
        $stmt = $this->db->prepare('UPDATE tasks SET completed = :completed WHERE id = :id');
        $stmt->execute(['completed' => (int)$completed, 'id' => $id]);
        return $stmt->rowCount() > 0;

    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}