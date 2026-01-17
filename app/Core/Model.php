<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;

abstract class Model
{
    // PDO database connection
    protected PDO $db;

    // Database table name
    protected string $table;

    public function __construct()
    {
        // Get PDO connection
        $this->db = Database::getInstance()->connection();
    }

    /* =========================
       SAFE QUERY EXECUTION
    ========================= */

    protected function run(string $sql, array $params = []): \PDOStatement
    {
        try {
            // Prepare SQL statement
            $stmt = $this->db->prepare($sql);

            // Execute statement with parameters
            $stmt->execute($params);

            // Return executed statement
            return $stmt;
        }catch (PDOException $e) {
            Logger::error($e);
            die('DB ERROR: ' . $e->getMessage()); // Temporary debug
        }

    }

    /* =========================
       CRUD METHODS
    ========================= */

    // Get all records
    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find record by ID
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->run($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Insert new record
    public function create(array $data): int
    {
        $columns = array_keys($data);
        $columns = array_map(fn($col) => "`$col`", $columns);

        $placeholders = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ")
                VALUES ({$placeholders})";

        $this->run($sql, $data);

        // Return inserted ID
        return (int)$this->db->lastInsertId();
    }

    // Update record by ID
    public function update(int $id, array $data): bool
    {
        $fields = [];

        // Build update fields
        foreach ($data as $key => $value) {
            $fields[] = "`{$key}` = :{$key}";
        }

        // Add ID to parameters
        $data['id'] = $id;

        $sql = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id = :id";
        $this->run($sql, $data);

        return true;
    }

    // Delete record by ID
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $this->run($sql, ['id' => $id]);
        return true;
    }

    /* =========================
       GENERIC HELPERS
    ========================= */

        // Find record by column
        public function findBy(string $column, mixed $value): ?array
        {
            $sql = "SELECT * FROM {$this->table} WHERE `{$column}` = :value LIMIT 1";
            return $this->run($sql, ['value' => $value])->fetch(PDO::FETCH_ASSOC) ?: null;
        }

        // Get multiple records by column
        public function getWhere(string $column, mixed $value): array
        {
            $sql = "SELECT * FROM {$this->table} WHERE `{$column}` = :value";
            return $this->run($sql, ['value' => $value])->fetchAll(PDO::FETCH_ASSOC);
        }

        // Check if record exists
        public function exists(string $column, mixed $value): bool
        {
            $sql = "SELECT 1 FROM {$this->table} WHERE `{$column}` = :value LIMIT 1";
            return (bool)$this->run($sql, ['value' => $value])->fetchColumn();
        }

}
