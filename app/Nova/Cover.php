<?php

namespace App\Nova;

use Carbon\Carbon;
use App\Jobs\ProcessImages;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MorphTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Http\Requests\NovaRequest;
use Intervention\Image\ImageManagerStatic as IMG;

class Cover extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Cover::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'url'
    ];
    
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Cover Photos');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Cover Photo');
    }
    
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Media';
    
    /**
    * The side nav menu order.
    *
    * @var int
    */
    public static $priority = 14;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $now = Carbon::now();
        return [
            ID::make(__('ID'), 'id')->sortable(),
            
            MorphTo::make(__('Type'), 'Coverable')->types([
                Book::class,
                Periodic::class,
                Series::class,
                Amel::class,
                Publication::class
            ])->searchable(),
            
            Image::make(__('Cover Photo'), 'url', 'App\Nova\Cover')
                ->rules('required', 'mimes:jpeg,jpg')
                ->disk('do_spaces')
                ->store(function (Request $request, $model) use($now) {
 
                    $name = $request->Coverable_type . '-cover-' .
                            sha1($now->timestamp) . '.' . 
                            request()->file('url')->extension();

                    $path = 'wp-content/uploads/' .
                        $now->format('Y') . '/' .
                        $now->format('m') . '/';
                    
                    Storage::disk('do_spaces')->put($path . $name, file_get_contents($request->file('url')));

                    ProcessImages::dispatch($name, $path);
                    
                    return $path . $name;
                    
                })->prunable()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
