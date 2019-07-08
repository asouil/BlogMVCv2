<?php
namespace App\Model\Table;

use Core\Model\Table;

class ConfigTable extends Table
{
    public function getAllInIds(string $ids)
    {
        return $this->query("SELECT *
                FROM $this->table 
                WHERE id IN (" . $ids . ")");
    }
}
