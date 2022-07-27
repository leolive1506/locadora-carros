<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function addFilterByColumn(Request $request, Builder $query)
    {
        if (! is_null($request['columns'])) {
            $columns = str_replace(' ', '', $request['columns']);
            $query->selectRaw('id,' . $columns);
        }
    }

    protected function addFilter(string $fieldName, Request $request, Builder &$query)
    {
        if (! empty($request[$fieldName])) {
            $query->where($fieldName, $request[$fieldName]);
        }
    }

    protected function addFilterLike(string $fieldName, Request $request, Builder &$query)
    {
        if (! empty($request[$fieldName])) {
            $query->where($fieldName, 'like', '%'. $request[$fieldName] .'%');
        }
    }

    protected function getFilter(Request $request, Builder &$query)
    {
        /**
         *  modelo?page[orderBy]=id&page[order]=desc&nome=Ford
         */
        $orderBy = $request['page']['orderBy'] ?? 'id';
        $direction = $request['page']['order'] ?? 'desc';
        $size = $request['page']['size'] ?? 20;

        return $query->orderBy($orderBy, $direction)->paginate($size);
    }

    public function defaultSearch($model, Request $request, Builder $query)
    {
        $columnsModel = $model->getCommonColumns();
        $columnsLikeModel = $model->getLikeColumns();

        foreach ($columnsModel as $column) {
            $this->addFilter($column, $request, $query);
        }

        foreach ($columnsLikeModel as $column) {
            $this->addFilterLike($column, $request, $query);
        }

        // filter current column model
        $this->addFilterByColumn($request, $query);
    }
}
