<?php

namespace App\Models;

use App\Core\Model;

use PDO;


class Slider extends Model
{
    protected string $table = 'sliders';

    /**
     * Get all sliders with media path
     */
    public function getAllWithMedia(): array
    {
        $sql = "
            SELECT sliders.*,
                   media.path AS media_path
            FROM sliders
            LEFT JOIN media ON media.id = sliders.media_id
            ORDER BY sliders.`order` ASC
        ";

        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single slider with media
     */
    public function findWithMedia(int $id): ?array
    {
        $sql = "
            SELECT sliders.*,
                   media.path AS media_path
            FROM sliders
            LEFT JOIN media ON media.id = sliders.media_id
            WHERE sliders.id = :id
            LIMIT 1
        ";

        return $this->run($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
