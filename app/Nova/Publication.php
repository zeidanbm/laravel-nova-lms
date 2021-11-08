<?php

namespace App\Nova;

use App\Options\Status;
use App\Options\Quality;
use App\Nova\Lenses\Drafts;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Nova\Lenses\Published;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\UserFilter;
use App\Nova\Lenses\CreatedItems;
use Laravel\Nova\Fields\MorphOne;
use App\Nova\Filters\StatusFilter;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Publication extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Publication::class;

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
        'periodic_id'
    ];
    
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Periodic Publications');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Periodic Publication');
    }
    
    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon() 
    {
        return view('icons.file')->render();
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
    public static $priority = 4;

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
            
            BelongsTo::make(__('Periodic'), 'periodic', 'App\Nova\Periodic')
                    ->rules('required')
                    ->searchable()
                    ->showCreateRelationButton(),
            
            Text::make(__('Volume'), 'volume'),
                
            Number::make(__('Publication Number From'), 'from')
                    ->rules('exclude_if:status,draft', 'required'),
            
            Number::make(__('Publication Number To'), 'to'),
            
            Date::make(__('Publishing Date From'), 'from_date')
                ->format('MMM Y')
                ->rules('exclude_if:status,draft', 'required')
                ->hideFromIndex(),
            
            Date::make(__('Publishing Date To'), 'to_date')
                ->format('MMM Y')
                ->hideFromIndex(),
                
            Select::make(__('Quality'), 'quality_id')
                ->rules('required')
                ->options(Quality::get())
                ->default(1)
                ->displayUsingLabels()
                ->hideFromIndex(),
            
            MorphOne::make(__('Cover Photo'), 'cover', 'App\Nova\Cover'),
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
