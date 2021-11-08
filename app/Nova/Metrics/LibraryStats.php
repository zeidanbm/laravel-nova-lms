<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\DB;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Http\Requests\NovaRequest;

class LibraryStats extends Partition
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';
    
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $book_count = DB::table('books')
                        ->select('types.name_ar as name_ar', DB::raw('count(*) as total'))
                        ->join('types', 'books.type_id', '=', 'types.id')
                        ->groupBy('name_ar')
                        ->pluck('total','name_ar')->all();
        
        $periodic_count = DB::table('periodics')
                            ->select('types.name_ar as name_ar', DB::raw('count(*) as total'))
                            ->join('types', 'periodics.type_id', '=', 'types.id')
                            ->groupBy('name_ar')
                            ->pluck('total','name_ar')->all();
                            
        $publications_count = [
            __('Periodic Publications') => DB::table('publications')->count()
        ];

        return $this->result(array_merge($book_count, $periodic_count, $publications_count));
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(1);
        return 0;
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'library-stats';
    }
    
    /**
     * Get the displayable name of the metric
     *
     * @return string
     */
    public function name()
    {
        return __('Library Stats');
    }
}
