<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Partner extends Model
{
    protected string $table = 'partners';

    public function getAllWithMedia(): array
    {
        $sql = "
            SELECT partners.*,
                   media.path AS media_path
            FROM partners
            LEFT JOIN media ON media.id = partners.media_id
            ORDER BY partners.`order` ASC
        ";

        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithMedia(int $id): ?array
    {
        $sql = "
            SELECT partners.*,
                   media.path AS media_path
            FROM partners
            LEFT JOIN media ON media.id = partners.media_id
            WHERE partners.id = :id
            LIMIT 1
        ";

        return $this->run($sql, ['id' => $id])
                    ->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
