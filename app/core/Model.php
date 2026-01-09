<?php

namespace App\Core;

use PDO;

abstract class BaseModel
{
    // PDO connection to interact with the database
    protected PDO $db;

    // Name of the table associated with this model
    protected string $table;

    // Initialize the PDO connection on model creation
    public function __construct()
    {
        $this->db = Database::getInstance()->connection();
    }

    /* =========================
       CRUD OPERATIONS
       Basic operations: get, find, create, update, delete
    ========================= */

    // Fetch all records from the table
    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single record by its ID
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Insert a new record and return its ID
    public function create(array $data): int
    {
        // Prepare columns and placeholders for insertion
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }

    // Update an existing record by ID
    public function update(int $id, array $data): bool
    {
        // Prepare fields for update
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id = :id";
        $data['id'] = $id;

        return $this->db->prepare($sql)->execute($data);
    }

    // Delete a record by its ID
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->prepare($sql)->execute(['id' => $id]);
    }

    /* =========================
       GENERIC QUERIES
       Flexible queries based on column values
    ========================= */

    // Fetch a single record by a specific column value
    public function findBy(string $column, mixed $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Fetch all records that match a column value
    public function getWhere(string $column, mixed $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check if a record exists with a given column value
    public function exists(string $column, mixed $value): bool
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);

        return (bool)$stmt->fetchColumn();
    }
}
