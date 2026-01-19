<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Application extends Model
{
    protected string $table = 'applications';

    /**
     * Get all applications ordered by submitted DESC
     */
    public function getAllOrdered(): array
    {
        $sql = "
            SELECT *
            FROM applications
            ORDER BY submitted DESC
        ";

        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
