<?php

namespace App\Nova;

use App\Options\Status;
use App\Nova\Lenses\Drafts;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Nova\Lenses\Published;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\UserFilter;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Lenses\CreatedItems;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Filters\StatusFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Series extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Series::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title'
    ];
    
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Seriess');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Series');
    }
    
    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon() 
    {
        return view('icons.puzzle')->render();
    }
    
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Catalogs';
    
    /**
    * The side nav menu order.
    *
    * @var int
    */
    public static $priority = 2;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            
            Select::make(__('Status'), 'status')
                    ->rules('required')
                    ->options(Status::get())
                    ->default('draft')
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            Text::make(__('Title'), 'title')
                ->sortable()
                ->rules('required', 'max:200')
                ->creationRules('unique:series,title')
                ->updateRules('unique:series,title,{{resourceId}}'),
            
            Textarea::make(__('Biography'), 'body'),
            
            HasMany::make(__('Series Books'), 'books', 'App\Nova\Book'),
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
        return [
            new UserFilter,
            new StatusFilter
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Drafts(),
            new Published(),
            new CreatedItems()
        ];
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
