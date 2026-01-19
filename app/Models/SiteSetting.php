<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class SiteSetting extends Model
{
    protected string $table = 'site_settings';

    public function get(): array
    {
        $sql = "
            SELECT site_settings.*,
                   media.path AS logo_path
            FROM site_settings
            LEFT JOIN media ON media.id = site_settings.logo_m_id
            WHERE site_settings.id = 1
            LIMIT 1
        ";
        return $this->run($sql)->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateSettings(array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "`$key` = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $fields) . " WHERE id = 1";
        $this->run($sql, $data);
        return true;
    }
}
