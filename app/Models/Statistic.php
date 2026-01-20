<?php
namespace App\Models;

use App\Core\Model;

class Statistic extends Model
{
    protected string $table = 'statistics';

  
public function getActiveOrdered(): array
{
    $sql = "
        SELECT *
        FROM {$this->table}
        WHERE is_active = 1
        ORDER BY `order` ASC
    ";

    return $this->run($sql)->fetchAll(\PDO::FETCH_ASSOC);
}

}
