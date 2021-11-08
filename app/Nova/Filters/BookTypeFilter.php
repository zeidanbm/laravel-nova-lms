<?php

namespace App\Nova\Filters;

use App\Options\BookType;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class BookTypeFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    
    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Book Type');
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
        return $query->where('type_id', $value);
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
			__('Folder') => 1,
			__('Series') => 2,
			__('Picture Book') => 3,
			__('Manuscript') => 4,
			__('Book') => 5,
			__('Rare Book') => 6
		];
    }
}
