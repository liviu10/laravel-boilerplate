<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiHandleFilter
{
    /**
     * Apply filters to the given query based on the provided search criteria.
     *
     * @param Builder $query The query builder instance to apply filters to.
     * @param array $search An associative array containing the search criteria where
     * the keys represent the fields to filter and the values represent the filter values.
     * @return Builder The modified query builder instance after applying the filters.
     */
    public function handleApiFilter(Builder $query, array $search = []): Builder
    {
        if (!empty($search)) {
            foreach($search as $field => $value) {
                if ($field === 'id') {
                    $query->where($field, $value);
                } else {
                    $query->where($field, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return $query;
    }
}
