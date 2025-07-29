<?php

namespace App\src\core;

use App\src\core\AbstractModel;

class Model extends AbstractModel
{
    public function where(string $column, string $operator, $value): self
    {
        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => 'AND',
        ];

        $this->bindings[] = $value;

        return $this;
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}" . $this->buildWhereClause();

        return $this->query($sql)->fetchAll();
    }
}
