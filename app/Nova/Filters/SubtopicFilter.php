<?php

namespace App\Nova\Filters;

use App\Models\Subtopic;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Illuminate\Support\Facades\Log;

class SubtopicFilter extends Filter
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
        return __('The SubTopic');
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
        return $query->where('subtopic_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Subtopic::all()->pluck('id', 'name')->toArray();
    }
}
