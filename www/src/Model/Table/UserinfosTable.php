<?php
namespace App\Model\Table;

use Core\Model\Table;

class UserinfosTable extends Table
{
    public function findUserId($id){
        return $this->query("SELECT * FROM {$this->table} WHERE user_id=?", [$id]);
    }
}