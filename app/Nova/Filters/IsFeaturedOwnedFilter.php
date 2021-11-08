<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class IsFeaturedOwnedFilter extends BooleanFilter
{
    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Featured/Owned');
    }
    
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value['is_chosen']) {
            $query->where('is_chosen', !!$value['is_chosen']);
        }
        if ($value['is_owned']) {
            $query->where('is_owned', !!$value['is_owned']);
        }
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
             __('Is Chosen') => 'is_chosen',
             __('Is Owned') => 'is_owned'
        ];
    }
}
