<?php

namespace App\Nova;

use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\File as FileField;
use Laravel\Nova\Fields\MorphTo;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Http\Requests\NovaRequest;

class File extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\File::class;

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
        return __('Files');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('File');
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
    public static $priority = 15;

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
            
            MorphTo::make(__('Type'), 'fileable')->types([
                Book::class,
                Periodic::class,
                Series::class,
                Amel::class,
                Publication::class
            ])->searchable(),
            
            FileField::make(__('File'), 'url', 'App\Nova\File')
                ->rules('required', 'mimes:pdf,epub')
                ->disk('do_spaces')
                ->store(function (Request $request, $model) use($now) {
 
                    $name = $request->Fileable_type . '-file-' .
                            sha1($now->timestamp) . '.' . 
                            request()->file('url')->extension();

                    $path = 'wp-content/uploads/files/' .
                        $now->format('Y') . '/' .
                        $now->format('m') . '/';
                    
                    Storage::disk('do_spaces')->put($path . $name, file_get_contents($request->file('url')));
                    
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
