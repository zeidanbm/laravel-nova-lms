<?php

namespace App\Nova;

use App\Options\Status;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\UserFilter;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Filters\StatusFilter;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Quote extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Quote::class;

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
        'body'
    ];
    
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Quotes');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Quote');
    }
    
    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon() 
    {
        return view('icons.announcement')->render();
    }
    
    /**
    * The side nav menu order.
    *
    * @var int
    */
    public static $priority = 6;

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
            
            Textarea::make(__('The Quote'), 'body')
                    ->rules('required')
                    ->alwaysShow(),
                    
            Textarea::make(__('The Quote'), 'body')
                    ->onlyOnIndex()->displayUsing(function ($text) {
                        return Str::limit($text, 30);
                    }),
            
            BelongsTo::make(__('Author'), 'author', 'App\Nova\Author')
                    ->rules('required')
                    ->searchable()
                    ->showCreateRelationButton(),
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
