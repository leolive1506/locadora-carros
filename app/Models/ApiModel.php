<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ApiModel extends Model
{
    use HasFactory;
    protected $commonColumns = [];
    protected $likeColumns = [];

    public function getCommonColumns()
    {
        if (! empty($this->commonColumns)) {
            return array_diff($this->commonColumns, $this->getLikeColumns());
        }

        return array_diff($this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable()), $this->getLikeColumns());
    }

    public function getLikeColumns()
    {
        return $this->likeColumns;
    }
}
