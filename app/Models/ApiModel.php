<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    use HasFactory;
    protected $likeFiltersPropertys;

    public function getTableColumns()
    {
        return array_diff($this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable()), $this->getLikeFiltersPropertys());
    }

    public function getLikeFiltersPropertys()
    {
        return $this->likeFiltersPropertys;
    }
}
