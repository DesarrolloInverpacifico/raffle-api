<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateQueryBuilder
{
    public function paginate(Builder $query, Request $request, array $relations = ['']): Collection | AbstractPaginator
    {
        $isPaginate = filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN);
        $perPage = $request->limit ?? 10;
        $currentPage = $request->page ?? 1;

        if ($isPaginate) {
            $paginator = $query->paginate($perPage, ['*'], 'page', $currentPage);

            $items = $paginator->items();
            $total = $paginator->total();

            $pagination = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
                'path'  =>  $request->url(),
                'query' =>  $request->query(),
                'onEachSide'    =>  1
            ]);

            return $pagination;
        }

        return $query->with($relations)->get();
    }
}
