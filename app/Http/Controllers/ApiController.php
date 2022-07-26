<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function addFilterSearch(Request $request, Builder &$query, $with = null)
    {
        /**
         * @var string $columns "id,nome,imagem"
         * @var string $columnsMarca "id,nome,imagem"
         * @var string $filters filters=nome:=:Ford Ka
         *  columns=nome,imagem,lugares&columns_marca=id,nome,imagem&filters=nome:like:Ford%;abs:=:1
         */
        $columns = $request->get('columns');
        $filters = $request->get('filters');

        if (! is_null($columns)) {
            $columns = str_replace(' ', '', $columns);
            $query->selectRaw('id,marca_id,' . $columns);
        }

        if (! is_null($filters)) {
            $arrayFilters = explode(';', $filters);
            foreach ($arrayFilters as $filter) {
                $query->where([explode(':', $filter)]);
            }
        }
    }

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
}
