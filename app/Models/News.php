<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class News extends Model
{
    protected string $table = 'news';

    /**
     * Get all news with media path, ordered by newest first
     */
    public function getAllWithMedia(): array
    {
        $sql = "
            SELECT news.*,
                media.path AS media_path,
                media.name AS media_name
            FROM news
            LEFT JOIN media ON media.id = news.media_id
            ORDER BY news.created DESC
        ";
        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

        /**
     * Get single news with media
     */
    public function findWithMedia(int $id): ?array
    {
        $sql = "
            SELECT news.*,
                   media.path AS media_path,
                   media.name AS media_name
            FROM news
            LEFT JOIN media ON media.id = news.media_id
            WHERE news.id = :id
            LIMIT 1
        ";
        return $this->run($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
